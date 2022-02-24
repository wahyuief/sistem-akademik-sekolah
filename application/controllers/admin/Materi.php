<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materi extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_admin()) show_404();
		if(!verify_user()) show_404();
		$this->load->model('materi_model');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Daftar Materi',
			'menu' => 'materi'
		);
		$this->cache->redis->save('admin', $cache);
		$layout = 'admin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'admin/materi';
		}

		$sekolah['sekolah_id'] = _sekolah()->id;

		$data = array(
			'filepage' => 'materi.php',
			'data' => $this->materi_model->get($sekolah)
		);
		$this->load->view($layout, $data);
	}

	public function do_insert()
	{
		$sekolah = _sekolah()->id;
		$tahun = $this->input->post('tahun');

		$this->form_validation->set_rules('tahun', 'Tahun Materi', 'trim|required|is_unique[materi.tahun]');

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
			if ($this->materi_model->save(['sekolah_id'=>$sekolah, 'tahun'=>$tahun])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'materi'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal menambahkan data materi'
						)
					));
			}
		}
	}

	public function do_update($id)
	{
		$tahun = $this->input->post('tahun');

		$this->form_validation->set_rules('tahun', 'Tahun Materi', 'trim|required');

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
			if ($this->materi_model->edit($id, ['tahun'=>$tahun])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'materi'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal merubah data materi'
						)
					));
			}
		}
	}

	public function do_remove($id)
	{
		if(!verify_table('materi', $id)) show_404();

		if ($this->materi_model->remove($id)) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'success',
						'redirect_to' => 'materi'
					)
				));
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Gagal menghapus data materi'
					)
				));
		}
	}

}
