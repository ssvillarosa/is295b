<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth
 *
 * Handles user page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class User extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        checkUserLogin();
    }
  
    /**
    * Display list of users.
    */
    public function userList(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $this->load->view('common/header');
        $this->load->view('common/nav');
        
        $this->load->model('UserModel');
        $users=$this->UserModel->getUsers();
        $data['users'] = $users;
        $this->load->view('user/userList',$data);
        
        $this->load->view('common/footer');		
    }
    
    /**
    * Display user details.
    */
    public function view(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $this->load->view('common/header');
        $this->load->view('common/nav');
        $userId = $this->input->get('id');
        
        $this->load->model('UserModel');
        $user=$this->UserModel->getUserById($userId);
        $data['user'] = $user;
        $this->load->view('user/detailsView',$data);
    }
    
    /**
    * Update user details.
    */
    public function update(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        echo 'Update user.';
    }
    
    /**
    * Delete user.
    */
    public function delete(){
        if($this->session->userdata(SESS_USER_ROLE)==USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        echo 'Delete user.';
    }
}
