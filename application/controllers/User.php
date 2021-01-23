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
        
        $users=$this->UserModel->getUsers();
        $data['users'] = $users;
        $this->displayForm($data,'user/userList');	
    }
    
    /**
    * Display user details.
    */
    public function view(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $userId = $this->input->get('id');
        $user=$this->UserModel->getUserById($userId);
        $data['user'] = $user;
        $this->displayForm($data,'user/detailsView');
    }
    
    /**
    * Update user details.
    */
    public function updateDetails(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $this->setValidationDetails();
        $this->form_validation->set_rules('userId','User ID','required|integer');
        $user = $this->createUserObject(true);
        $user->id = $this->input->post('userId');
        $success = $this->UserModel->updateUserDetails($user,$user->id);
        if(!$success){
            // Set error message.
            $data["error_message"] = "Error occured.";        
        }else{
            // Set success message.
            $data["success_message"] = "User successfully updated!";
        }
        // Display form.
        $data["user"] = $user;
        $this->displayForm($data,'user/detailsView');
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
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $this->setValidationCredentials();
        $user = $this->createUserObject(true);
        if ($this->form_validation->run() == FALSE){
            $data["user"] = $user;
            $this->displayForm($data,'user/add');
            return;
        }
        $insert_id = $this->UserModel->addUser($user);
        if($insert_id == -1){
            // Set error message.
            $data["error_message"] = "Error occured.";        
        }else{
            // Set success message.
            $data["success_message"] = "User successfully added!";
        }
        // Display empty form.
        $data["user"] = $this->createUserObject(false);
        $this->displayForm($data,'user/add');
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
    private function displayForm($data,$form){
        $this->load->view('common/header');
        $this->load->view('common/nav');
        $this->load->view($form, $data);
        $this->load->view('common/footer');        
    }

    /**
    * Apply validation rules for username and password.
    */
    private function setValidationCredentials(){
        $this->form_validation->set_error_delimiters(
                '<div class="alert alert-danger">', '</div>'); 
        $this->form_validation->set_rules('username', 'Username',
                'trim|required|max_length[50]|callback_isUsernameUnique');
        $this->form_validation->set_rules('password', 'Password',
                'trim|required|max_length[50]');
        $this->form_validation->set_rules('confirm_password', 
                'Password Confirmation', 'required|matches[password]');
        $this->setValidationDetails();
    }
    
    /**
    * Apply validation rules for other details to be used in update form.
    */
    private function setValidationDetails(){
        $this->form_validation->set_rules('role','Role','required');
        $this->form_validation->set_rules('status','Status','required');
        $this->form_validation->set_rules('name', 'Name',
                'trim|required|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 
                'required|valid_email|max_length[255]');        
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
    
    /**
    * Display user profile.
    */
    public function profile(){
        $userId = $this->session->userdata(SESS_USER_ID);
        $user=$this->UserModel->getUserById($userId);
        $data['user'] = $user;
        $this->displayForm($data,'user/profile');
    }
    
    /**
    * Update user profile.
    */
    public function profileUpdate(){
        $this->form_validation->set_rules('name', 'Name',
                'trim|required|max_length[255]');
        $this->form_validation->set_rules('email', 'Email',
                'required|valid_email|max_length[255]');
        $user = $this->createUserObject(true);
        $userId = $this->session->userdata(SESS_USER_ID);
        $success = $this->UserModel->updateUserProfile($user,$userId);
        if(!$success){
            // Set error message.
            $data["error_message"] = "Error occured.";        
        }else{
            // Set success message.
            $data["success_message"] = "Profile successfully updated!";
        }
        // Display form.
        $data["user"] = $user;
        $this->displayForm($data,'user/profile');
    }
}
