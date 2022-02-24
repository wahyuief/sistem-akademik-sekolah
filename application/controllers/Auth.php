<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        if($this->aauth->is_loggedin()){
			if ($this->aauth->is_admin()) {
				redirect('administrator/dashboard');
			} else {
				redirect('dashboard');
			}
		}
	}

	public function login()
	{
		$layout = 'auth/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'auth/login';
		}

		$data = array(
			'filepage' => 'login.php'
		);
		$this->load->view($layout, $data);
	}

	public function do_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$this->form_validation->set_rules('username', 'Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		
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
			if ($this->aauth->login($username, $password, true)) {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(
							array(
								'status' => 'success',
								'redirect_to' => '../ngadimin/dashboard'
							)
						));
			} else {
				$this->output
						->set_content_type('application/json')
						->set_output(json_encode(
							array(
								'status' => 'error',
								'message' => 'Username atau password salah'
							)
						));
			}
		}
	}

	public function register()
	{
		$layout = 'auth/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'auth/register';
		}

		$data = array(
			'filepage' => 'register.php'
		);
		$this->load->view($layout, $data);
	}

	public function do_register()
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
				$this->aauth->login_fast($user);
				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(
						array(
							'status' => 'success',
							'redirect_to' => 'login'
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

	public function forgot()
	{
		$layout = 'auth/layout';
		if ($this->input->post('ajax') === 'YES') {
			$layout = 'auth/forgot';
		}

		$data = array(
			'filepage' => 'forgot.php'
		);
		$this->load->view($layout, $data);
	}

	public function do_forgot()
	{
		$email = $this->input->post('email');

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
			$this->aauth->remind_password($email);
			$this->output
				->set_content_type('application/json')
				->set_output(json_encode(
					array(
						'status' => 'success',
					)
				));
		}
	}

}