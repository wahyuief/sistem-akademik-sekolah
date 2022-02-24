<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kurikulum extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_admin()) show_404();
		if(!verify_user()) show_404();
		$this->load->model('kurikulum_model');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Daftar Kurikulum',
			'menu' => 'kurikulum'
		);
		$this->cache->redis->save('admin', $cache);
		$layout = 'admin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'admin/kurikulum';
		}

		$sekolah['sekolah_id'] = _sekolah()->id;

		$data = array(
			'filepage' => 'kurikulum.php',
			'data' => $this->kurikulum_model->get($sekolah)
		);
		$this->load->view($layout, $data);
	}

	public function do_insert()
	{
		$sekolah = _sekolah()->id;
		$tahun = $this->input->post('tahun');

		$this->form_validation->set_rules('tahun', 'Tahun Kurikulum', 'trim|required|is_unique[kurikulum.tahun]');

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
			if ($this->kurikulum_model->save(['sekolah_id'=>$sekolah, 'tahun'=>$tahun])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'kurikulum'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal menambahkan data kurikulum'
						)
					));
			}
		}
	}

	public function do_update($id)
	{
		$tahun = $this->input->post('tahun');

		$this->form_validation->set_rules('tahun', 'Tahun Kurikulum', 'trim|required');

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
			if ($this->kurikulum_model->edit($id, ['tahun'=>$tahun])) {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'kurikulum'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => 'Gagal merubah data kurikulum'
						)
					));
			}
		}
	}

	public function do_remove($id)
	{
		if(!verify_table('kurikulum', $id)) show_404();

		if ($this->kurikulum_model->remove($id)) {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'success',
						'redirect_to' => 'kurikulum'
					)
				));
		} else {
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'error',
						'message' => 'Gagal menghapus data kurikulum'
					)
				));
		}
	}

}
