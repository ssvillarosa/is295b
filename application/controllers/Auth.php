<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function login(){
        $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[50]');
        if ($this->form_validation->run() == FALSE){
                $this->load->view('common/header');
                $this->load->view('login');
                $this->load->view('common/footer');
        }else{
                redirect('user/userList');
        }
    }
    
}
