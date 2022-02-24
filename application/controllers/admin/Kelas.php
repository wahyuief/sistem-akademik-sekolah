<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_admin()) show_404();
		if(!verify_user()) show_404();
		$this->load->model('kelas_model');
		$this->load->model('siswa_model');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Daftar Kelas',
			'menu' => 'kelas'
		);
		$this->cache->redis->save('admin', $cache);
		$layout = 'admin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'admin/kelas';
		}

		$sekolah['sekolah_id'] = _sekolah()->id;

		$data = array(
			'filepage' => 'kelas.php',
			'data' => $this->kelas_model->get($sekolah),
			'kurikulum' => db_get_all_data('kurikulum', $sekolah),
			'walikelas' => $this->aauth->list_users(5),
			'sekolah_id' => $sekolah['sekolah_id']
		);
		$this->load->view($layout, $data);
	}

	public function siswa($id)
	{
		if(!verify_table('kelas', $id)) show_404();
		$kelas = _kelas(['id'=>$id]);
		$cache = array(
			'title' => 'Admin - Daftar Siswa Kelas '. $kelas->nama,
			'menu' => 'kelas'
		);
		$this->cache->redis->save('admin', $cache);
		$layout = 'admin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'admin/kelas';
		}

		$data = array(
			'filepage' => 'kelas_siswa.php',
			'data' => $this->siswa_model->get(['kelas_id'=>$id]),
			'siswa' => $this->aauth->list_users(6),
			'sekolah_id' => _sekolah(),
			'kelas' => $kelas
		);
		$this->load->view($layout, $data);
	}

	public function data_siswa($id)
	{
		if(!verify_table('kelas', $id)) show_404();
		$start = $this->input->post('start');
		$rowperpage = $this->input->post('length');
		$searchValue = $this->input->post('search')['value'];
		
		$searchQuery = "";
		if($searchValue != ''){
			$searchQuery = " (fullname like '%".$searchValue."%' or username like '%".$searchValue."%' or email like '%".$searchValue."%' ) ";
		}

		$users = $this->aauth->list_users(6, $rowperpage, $start, true, false, $searchQuery);
		$total_user = $this->aauth->list_users(6);
		$i = 1;
		$user = [];
		foreach ($users as $row) {
			$kelas_id = (isset(_kelas_siswa(['siswa'=>$row->id])->kelas_id) ? _kelas_siswa(['siswa'=>$row->id])->kelas_id : 0);
			$user[] = array(
				'id' => $i++,
				'username' => $row->username,
				'fullname' => $row->fullname,
				'kelas' => '<span id="namaKelas'.$row->id.'">'.($kelas_id ? (isset(_kelas(['id'=>$kelas_id])->nama) ? _kelas(['id'=>$kelas_id])->nama : '-') : '-').'</span>',
				'opsi' => ($kelas_id ? ($kelas_id === $id ? '' : '<a href="javascript:;" class="pindah-siswa" dataid="'._kelas_siswa(['siswa'=>$row->id])->id.'" kelas="'.$id.'" siswa="'.$row->id.'">Pindah</a>') : '<a href="javascript:;" class="tambah-siswa" kelas="'.$id.'" siswa="'.$row->id.'">Tambah</a>')
			);
		}
		$data = array(
			'draw' => $this->input->post('draw'),
			'recordsTotal' => count($total_user),
			'recordsFiltered' => count($total_user),
			'data' => $user
		);
		echo (isset($user) ? json_encode($data) : json_encode(['data'=>[]]));
	}

	public function do_insert()
	{
		$sekolah = _sekolah()->id;
		$kelas = $this->input->post('kelas');
		$kurikulum = $this->input->post('kurikulum');
		$walikelas = $this->input->post('walikelas');

		$this->form_validation->set_rules('kelas', 'Kelas', 'trim|required');
		$this->form_validation->set_rules('kurikulum', 'Kurikulum', 'trim|required');
		$this->form_validation->set_rules('walikelas', 'Wali Kelas', 'trim|required|is_unique[kelas.walikelas]');

		if ($this->form_validation->run() === FALSE) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => strip_tags(validation_errors())
					)
				));
		} else {
			if ($this->kelas_model->save(['sekolah_id'=>$sekolah, 'nama'=>$kelas, 'kurikulum'=>$kurikulum, 'walikelas'=>$walikelas])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'kelas'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal menambahkan data kelas'
						)
					));
			}
		}
	}

	public function tambah_siswa()
	{
		$sekolah = _sekolah()->id;
		$kelas = $this->input->get('kelas');
		$siswa = $this->input->get('siswa');
		if(!verify_siswa($siswa)) show_404();

		if ($this->siswa_model->get(['sekolah_id'=>$sekolah, 'kelas_id'=>$kelas, 'siswa'=>$siswa, 'tahun'=>date('Y')])) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Siswa sudah terdaftar di kelas ini'
					)
				));
			return false;
		}

		if ($this->siswa_model->save(['sekolah_id'=>$sekolah, 'kelas_id'=>$kelas, 'siswa'=>$siswa, 'tahun'=>date('Y')])) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'success',
						'kelas' => _kelas(['id'=>$kelas])->nama
					)
				));
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Gagal menambahkan siswa kelas'
					)
				));
		}
	}

	public function pindah_siswa()
	{
		$id = $this->input->get('id');
		$kelas = $this->input->get('kelas');
		$siswa = $this->input->get('siswa');
		if(!verify_siswa($siswa)) show_404();

		if ($this->siswa_model->edit($id, ['kelas_id'=>$kelas, 'siswa'=>$siswa])) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'success',
						'kelas' => _kelas(['id'=>$kelas])->nama
					)
				));
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Gagal memindahkan siswa kelas'
					)
				));
		}
	}

	public function do_update($id)
	{
		if(!verify_table('kelas', $id)) show_404();
		$kelas = $this->input->post('kelas');
		$kurikulum = $this->input->post('kurikulum');
		$walikelas = $this->input->post('walikelas');

		$this->form_validation->set_rules('kelas', 'Kelas', 'trim|required');
		$this->form_validation->set_rules('kurikulum', 'Kurikulum', 'trim|required');
		$this->form_validation->set_rules('walikelas', 'Wali Kelas', 'trim|required');

		if ($this->form_validation->run() === FALSE) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => strip_tags(validation_errors())
					)
				));
		} else {
			if ($this->kelas_model->edit($id, ['nama'=>$kelas, 'kurikulum'=>$kurikulum, 'walikelas'=>$walikelas])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'kelas'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal merubah data kelas'
						)
					));
			}
		}
	}

	public function do_remove($id)
	{
		if(!verify_table('kelas', $id)) show_404();

		if ($this->kelas_model->remove($id)) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'success',
						'redirect_to' => 'kelas'
					)
				));
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Gagal menghapus data kelas'
					)
				));
		}
	}

}
