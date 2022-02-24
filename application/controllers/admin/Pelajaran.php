<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelajaran extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_admin()) show_404();
		if(!verify_user()) show_404();
		$this->load->model('pelajaran_model');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Daftar Pelajaran',
			'menu' => 'pelajaran'
		);
		$this->cache->redis->save('admin', $cache);
		$layout = 'admin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'admin/pelajaran';
		}

		$sekolah['sekolah_id'] = _sekolah()->id;

		$data = array(
			'filepage' => 'pelajaran.php',
			'data' => $this->pelajaran_model->get($sekolah)
		);
		$this->load->view($layout, $data);
	}

	public function do_insert()
	{
		$sekolah = _sekolah()->id;
		$kode = $this->input->post('kode');
		$nama = $this->input->post('nama');

		$this->form_validation->set_rules('kode', 'Kode Pelajaran', 'trim|required|is_unique[pelajaran.kode]');
		$this->form_validation->set_rules('nama', 'Nama Pelajaran', 'trim|required|is_unique[pelajaran.nama]');

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
			if ($this->pelajaran_model->save(['sekolah_id'=>$sekolah, 'kode'=>$kode, 'nama'=>$nama])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'pelajaran'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal menambahkan data pelajaran'
						)
					));
			}
		}
	}

	public function do_update($id)
	{
		$kode = $this->input->post('kode');
		$nama = $this->input->post('nama');

		$this->form_validation->set_rules('kode', 'Kode Pelajaran', 'trim|required');
		$this->form_validation->set_rules('nama', 'Nama Pelajaran', 'trim|required');

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
			if ($this->pelajaran_model->edit($id, ['kode'=>$kode, 'nama'=>$nama])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'pelajaran'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal merubah data pelajaran'
						)
					));
			}
		}
	}

	public function do_remove($id)
	{
		if(!verify_table('pelajaran', $id)) show_404();

		if ($this->pelajaran_model->remove($id)) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'success',
						'redirect_to' => 'pelajaran'
					)
				));
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Gagal menghapus data pelajaran'
					)
				));
		}
	}

}
