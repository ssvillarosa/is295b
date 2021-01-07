<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function index(){
		$this->load->helper('url');
	}
	
	public function login(){
		$this->load->helper(array('form', 'url'));
		/*$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE){
			$this->load->view('common/header');
			$this->load->view('login');
			$this->load->view('common/footer');
		}else{
			echo 'Success';
		}*/
	}
}
