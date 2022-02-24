<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_ngadimin()) redirect('/');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Dashboard Sekolah',
			'menu' => 'dashboard'
		);

		$this->cache->redis->save('ngadimin', $cache);
		$layout = 'ngadimin/layout';

		if ($this->input->post('ajax') === 'YES') {
			$layout = 'ngadimin/dashboard';
		}

		$where = array('hapus' => '0');
		$data = array(
			'filepage' => 'dashboard.php',
		);
		
		$this->load->view($layout, $data);
	}
}
