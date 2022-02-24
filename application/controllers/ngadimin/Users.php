<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
		if(!$this->aauth->is_loggedin() || !$this->aauth->is_ngadimin()) redirect('/');
	}

	public function index()
	{
		$cache = array(
			'title' => 'Admin - Daftar Pengguna',
			'menu' => 'users'
		);
		$this->cache->redis->save('ngadimin', $cache);
		$layout = 'ngadimin/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'ngadimin/users';
		}

		$data = array(
			'filepage' => 'users.php'
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
				$searchQuery = " (fullname like '%".$searchValue."%' or username like '%".$searchValue."%' or email like '%".$searchValue."%' ) ";
			}

			$users = $this->aauth->list_users(false, $rowperpage, $start, true, "$columnName $columnSortOrder");
			$total_user = $this->aauth->list_users(false, false, false, true);
			$i = 1;
			$user = [];
			foreach ($users as $row) {
				$sekolah_id = _sekolah()->id;
				$user[] = array(
					'id' => $i++,
					'fullname' => $row->fullname,
					'username' => $row->username,
					'email' => $row->email,
					'sekolah' => (_sekolah() ? _sekolah()->nama : '-'),
					'status' => ($row->banned == 0 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Banned</span>'),
					'last_login' => date('d M Y H:i:s', strtotime($row->last_login)),
					'opsi' => '<a href="'.base_url('ngadimin/users/do_update/'.$row->id).'" class="linkEdit" fullname="'.$row->fullname.'" username="'.$row->username.'" email="'.$row->email.'" status="'.$row->banned.'">Edit</a>'
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
	}

	public function do_insert()
	{
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|min_length[4]|is_unique[aauth_users.fullname]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|is_unique[aauth_users.username]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[aauth_users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[7]');

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
			if ($user = $this->aauth->create_user($email, $password, $username, $fullname, 4)) {
				$avatar = save_avatar($username);
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'users'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => $this->aauth->print_errors()
						)
					));
			}
		}
	}

	public function do_update($user_id)
	{
		$fullname = $this->input->post('fullname');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$status = $this->input->post('status');

		$this->form_validation->set_rules('fullname', 'fullname', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

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
			if ($status == '0') {
				$this->aauth->unban_user($user_id);
				$update = true;
			} else {
				$this->aauth->ban_user($user_id);
				$update = true;
			}

			if ($update) {
				$this->aauth->update_user($user_id, $email, ($password ? $password : false), $username, $fullname);
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'users'
						)
					));
			} else {
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'error',
							'message' => $this->aauth->print_errors()
						)
					));
			}
		}
	}

}
