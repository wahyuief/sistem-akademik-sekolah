<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_admin()) redirect('/');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Dashboard Sekolah',
			'menu' => 'dashboard'
		);
		$this->cache->redis->save('admin', $cache);
		$layout = 'admin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'admin/dashboard';
		}

		$where = array('hapus' => '0');
		$data = array(
			'filepage' => 'dashboard.php',
		);
		
		$this->load->view($layout, $data);
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
			$simpan = 0;

			if (isset($this->aauth->get_user()->sekolah)) {
				if (db_get_data('sekolah', ['user_id'=>$this->session->userdata('id')])) {
					$simpan += 1;
				}
			}

			if (db_get_data('sekolah', ['npsn'=>$data['npsn']])) {
				$simpan += 1;
			}

			if ($simpan === 0) {
				$sekolah_id = $this->dashboard_model->save($data);
				$this->kolaan->tambah_sekolah($sekolah_id);
				$this->aauth->set_user_var('sekolah', $sekolah_id);
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => base_url('admin/dashboard')
						)
					));
			} else if ($simpan === 1) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Anda sudah menjadi pendaftar sekolah'
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

	public function get_npsn($nomor)
	{
		if ($this->input->post('wahyuganteng') === '0HYE4H') {
			echo $this->kolaan->get_npsn($nomor);
		} else {
			redirect('/');
		}
	}
}
