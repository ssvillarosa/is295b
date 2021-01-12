<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
    }
    
    public function login(){
        $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[50]');
        if ($this->form_validation->run() == FALSE){
            $this->displayLoginForm();
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if(!$this->isLoginValid($username,$password)) return;
            //TODO: log user activity
            redirect('user/userList');
        }
    }
    
    private function isLoginValid($username,$password){
        $user = $this->UserModel->getUserByUsername($username);
        // check if the username is valid.
        if(!$user){
            $this->displayLoginForm('Invalid username/password.');
            return false;
        }
        // check if username is blocked.
        if($user->status == USER_STATUS_BLOCKED){
            echo "User is blocked. Please contact the administrator.";
            return false;
        }
        // check if the credentials are valid
        $user = $this->UserModel->getUserByCred($username,$password);
        if(!$user){
            $this->displayLoginForm('Invalid username/password.');
            //TODO: log user activity and check if how many trials before block.
            return false;
        }
        return true;
    }
    
    private function displayLoginForm($error_message=NULL){
        $this->load->view('common/header');
        if($error_message){
            $this->load->view('login',array('error_message'=>'Invalid username/password.'));
        }else{
            $this->load->view('login');            
        }
        $this->load->view('common/footer');
    }
}
