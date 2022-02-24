<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sekolah extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_ngadimin()) redirect('/');
		$this->load->model('sekolah_model');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Daftar Sekolah',
			'menu' => 'sekolah'
		);
		
		$this->cache->redis->save('ngadimin', $cache);
		$layout = 'ngadimin/layout';

		if ($this->input->post('ajax') === 'YES') {
			$layout = 'ngadimin/sekolah';
		}

		$data = array(
			'filepage' => 'sekolah.php'
		);

		$this->load->view($layout, $data);
	}

	public function get_data()
	{
		if ($this->input->get('wahyugantengbanget') === 'c0meok210ei1ej21i') {
			$start = $this->input->post('start');
			$rowperpage = $this->input->post('length');
			$columnIndex = $this->input->post('order')[0]['column'];
			$columnName = $this->input->post('columns')[$columnIndex]['data'];
			$columnSortOrder = $this->input->post('order')[0]['dir'];
			$searchValue = $this->input->post('search')['value'];

			$searchQuery = "";
			if($searchValue != ''){
				$searchQuery = " (npsn like '%".$searchValue."%' or nama like '%".$searchValue."%' ) ";
			}

			$sekolah = $this->sekolah_model->get(null, $searchQuery, $columnName, $columnSortOrder, $rowperpage, $start);
			$total_sekolah = $this->sekolah_model->get();
			$i = 1;
			$sekolahan = [];
			foreach ($sekolah as $row) {
				$sekolahan[] = array(
					'id' => $i++,
					'npsn' => '<img src="'.base_url('uploads/'.$row->logo).'" width="32"> '.$row->npsn,
					'nama' => $row->nama.'<br>'.$row->slug.'.kolaan.id',
					'akreditasi' => $row->akreditasi,
					'pembuat' => $this->aauth->get_user($row->user_id)->username,
					'dibuat' => date('d M Y H:i:s', strtotime($row->tanggal)),
					'opsi' => '<a href="'.base_url('ngadimin/sekolah/do_update/'.$row->id).'" class="linkEdit" npsn="'.$row->npsn.'" nama="'.$row->nama.'" slug="'.$row->slug.'" alamat="'.$row->alamat.'" akreditasi="'.$row->akreditasi.'" status="'.$row->status.'" jenjang="'.$row->jenjang.'">Edit</a>'
				);
			}
			$data = array(
				'draw' => $this->input->post('draw'),
				'recordsTotal' => count($total_sekolah),
				'recordsFiltered' => count($total_sekolah),
				'data' => $sekolahan
			);
			echo (isset($sekolahan) ? json_encode($data) : json_encode(['data'=>[]]));
		}
	}

	public function do_insert()
	{
		$config['upload_path']          = './uploads/';
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['max_size']             = 1024;
		$config['file_ext_tolower']     = TRUE;
		$config['encrypt_name']         = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		$this->upload->do_upload('logo');
		$picture = $this->upload->data('file_name');

		$data = array(
			'user_id' => $this->session->userdata('id'),
			'npsn' => $this->input->post('npsn'),
			'nama' => $this->input->post('nama'),
			'slug' => $this->input->post('slug'),
			'logo' => $picture,
			'alamat' => $this->input->post('alamat'),
			'akreditasi' => $this->input->post('akreditasi'),
			'status' => $this->input->post('status'),
			'jenjang' => $this->input->post('jenjang'),
		);

		$this->form_validation->set_rules('npsn', 'NPSN', 'trim|required|is_numeric|is_unique[sekolah.npsn]');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required|is_unique[sekolah.nama]');
		$this->form_validation->set_rules('slug', 'Subdomain', 'trim|required|is_unique[sekolah.slug]');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('akreditasi', 'Akreditasi', 'required');
		$this->form_validation->set_rules('status', 'Status Sekolah', 'required');
		$this->form_validation->set_rules('jenjang', 'Jenjang Pendidikan', 'required');

		
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
			$simpan = true;
			if ($this->aauth->is_admin()) {
				if (db_get_data('sekolah', ['user_id'=>$this->session->userdata('id')])) {
					$simpan = false;
				}
			}  // 1 orang cukup 1 sekolah

			if ($simpan) {
				$sekolah_id = $this->sekolah_model->save($data);
				db_update_data('aauth_users', ['sekolah' => $sekolah_id], ['id'=>_sesi('id')]);
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(
							array(
								'status' => 'success',
								'redirect_to' => base_url('ngadimin/sekolah')
							)
						));
			} else {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(
							array(
								'status' => 'error',
								'message' => 'Sekolah sudah pernah didaftarkan'
							)
						));
			}
		}
	}

	public function do_update($id)
	{
		$data = $this->sekolah_model->get_where(['id'=>$id]);

		if ($this->aauth->is_admin()) {
			$data = $this->sekolah_model->get_where(['id'=>$id,'user_id'=>$this->session->userdata('id')]);
		}

		if ($_FILES['logo']['error'] === 0) {
			$config['upload_path']          = './uploads/';
			$config['allowed_types']        = 'jpg|jpeg|png';
			$config['max_size']             = 1024;
			$config['file_ext_tolower']     = TRUE;
			$config['encrypt_name']         = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			$this->upload->do_upload('logo');
			$picture = $this->upload->data('file_name');
		} else {
			$picture = $data->logo;
		}

		$data = array(
			'npsn' => $this->input->post('npsn'),
			'nama' => $this->input->post('nama'),
			'slug' => $this->input->post('slug'),
			'logo' => $picture,
			'alamat' => $this->input->post('alamat'),
			'akreditasi' => $this->input->post('akreditasi'),
			'status' => $this->input->post('status'),
			'jenjang' => $this->input->post('jenjang'),
		);

		$this->form_validation->set_rules('npsn', 'NPSN', 'trim|required|is_numeric');
		$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
		$this->form_validation->set_rules('slug', 'Subdomain', 'trim|required');
		$this->form_validation->set_rules('alamat', 'Alamat', 'required');
		$this->form_validation->set_rules('akreditasi', 'Akreditasi', 'required');
		$this->form_validation->set_rules('status', 'Status Sekolah', 'required');
		$this->form_validation->set_rules('jenjang', 'Jenjang Pendidikan', 'required');
		
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
			if ($this->sekolah_model->edit($id, $data)) {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(
							array(
								'status' => 'success',
								'redirect_to' => base_url('ngadimin/sekolah')
							)
						));
			} else {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(
							array(
								'status' => 'error',
								'message' => 'Gagal merubah data sekolah'
							)
						));
			}
		}
	}

	public function get_npsn($nomor)
	{
		if ($this->input->post('wahyuganteng') === 'OHYEAH') {
			echo $this->kolaan->get_npsn($nomor);
		} else {
			redirect('/');
		}
	}
}
