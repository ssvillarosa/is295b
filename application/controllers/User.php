<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        /*if ($this->session->userdata['logged'] == TRUE){
            //do something
        }else{
            redirect('auth/login');
        }*/
    }
  
    public function userList(){
        $this->load->view('common/header');
        $this->load->view('common/nav');
        
        $this->load->model('UserModel');
        $users=$this->UserModel->getUsers();
        $data['users'] = $users;
        $this->load->view('user/userList',$data);
        
        $this->load->view('common/footer');		
    }
    
    public function view(){
        $this->load->view('common/header');
        $this->load->view('common/nav');
        $userId = $this->input->get('id');
        
        $this->load->model('UserModel');
        $user=$this->UserModel->getUser($userId);
        $data['user'] = $user;
        $this->load->view('user/detailsView',$data);
    }
}
