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
        $this->load->model('UserModel');
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
        
    /**
    * Add user.
    */
    public function add(){
        $this->setValidationRules();
        $user = $this->createUserObject(true);
        if ($this->form_validation->run() == FALSE){
            $data["user"] = $user;
            $this->displayAddForm($data);
            return;
        }
        // Remove the confirm_password before sending to the model.
        unset($user->confirm_password);
        $this->UserModel->addUser($user);
        // Display Success Message and display form.
        $data["success_message"] = "User successfully added!";
        // Create empty user object.
        $data["user"] = $this->createUserObject(false);
        $this->displayAddForm($data);
    }
    
    /**
    * Creates user object.
    * 
    * @param    boolean  $post          If true, it will create object from post data. Otherwise, it will create object with properties but values are blank.
    * @param    boolean  $addConfirm    If true, it will include the confirm_password to the object.
    * @return   user object
    */
    private function createUserObject($post){
        $user = (object)[
            'username' => $post ? $this->input->post('username'): '',
            'password' => $post ? $this->input->post('password'): '',
            'confirm_password' => $post ? $this->input->post('confirm_password'): '',
            'role' => $post ? $this->input->post('role'): '',
            'status' => $post ? $this->input->post('status'): '',
            'email' => $post ? $this->input->post('email'): '',
            'contact_number' => $post ? $this->input->post('contact_number'): '',
            'name' => $post ? $this->input->post('name'): '',
            'address' => $post ? $this->input->post('address'): '',
            'birthday' => $post ? $this->input->post('birthday'): '',
        ];
        return $user;
    }
    
    /**
    * Displays add form.
    */
    private function displayAddForm($data){
        $this->load->view('common/header');
        $this->load->view('common/nav');
        $this->load->view('user/add', $data);
        $this->load->view('common/footer');        
    }


    /**
    * Apply validation rules.
    */
    private function setValidationRules(){
        $this->form_validation->set_error_delimiters(
                '<div class="alert alert-danger">', '</div>'); 
        $this->form_validation->set_rules('username', 'Username',
                'trim|required|max_length[50]|callback_isUsernameUnique');
        $this->form_validation->set_rules('password', 'Password',
                'trim|required|max_length[50]');
        $this->form_validation->set_rules('confirm_password', 
                'Password Confirmation', 'required|matches[password]');
        $this->form_validation->set_rules('role','Role','required');
        $this->form_validation->set_rules('name', 'Name',
                'trim|required|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 
                'required|valid_email');
    }
        
    /**
    * Returns true if the username does not exist in the database.
    *
    * @param    string  $username   Username string
    * @return   boolean
    */
    public function isUsernameUnique($username){
        $user = $this->UserModel->getUserByUsername($username);
        // Check if the username is valid.
        if($user){
            $this->form_validation->set_message('isUsernameUnique', 
                    'Username already exist.');
            return false;
        }
        return true;
    }
}
