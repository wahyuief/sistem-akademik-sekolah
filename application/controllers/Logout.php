<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
    public function index()
	{
		$this->aauth->logout();
		redirect(base_url());
	}
}