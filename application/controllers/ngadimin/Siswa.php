<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_ngadimin()) redirect('/');
		$this->load->model('dashboard_model');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Data Siswa',
			'menu' => 'dashboard'
		);
		$this->cache->redis->save('admin', $cache);
		$layout = 'admin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'admin/dashboard';
		}

		if ($this->aauth->is_mimin()) {
			if ($this->input->post('ajax') === 'YES') {
				$layout = 'admin/dashboard-mimin';
			}
			$where = array('user_id' => $this->session->userdata('id'), 'hapus' => '0');
			$data = array(
				'filepage' => 'dashboard-mimin.php',
				'subpage' => 'data-siswa.php',
				'data' => $this->dashboard_model->get($where)
			);
		} else {
			$where = array('hapus' => '0');
			$data = array(
				'filepage' => 'dashboard.php',
				'data' => $this->dashboard_model->get($where)
			);
		}
		
		$this->load->view($layout, $data);
	}

	public function get_data()
	{
		error_reporting(0);
		if ($this->input->get('wahyugantengbanget') === '98r2de3j9ijsi1ie') {
			$user_id = $this->session->userdata('id');
			$users = $this->aauth->list_users(6, false, false, true);
			$sekolah = $this->db->get_where('sekolah', ['user_id'=>$user_id])->row();
			$i = 1;
			foreach ($users as $row) {
				if (_sekolah()->id === $sekolah->id) {
					$user[] = array(
						$i++,
						$row->username,
						$row->email,
						($row->banned == 0 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Banned</span>'),
						date('d M Y H:i:s', strtotime($row->last_login)),
						'edit'
					);
				}
			}
			$data = array(
				'draw' => 1,
				'recordsTotal' => count($user),
				'recordsFiltered' => count($user)
			);
			$data['data'] = $user;
			echo (isset($user) ? json_encode($data) : json_encode(['data'=>[]]));
		}
	}
}
