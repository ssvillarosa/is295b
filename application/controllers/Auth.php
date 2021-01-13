<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Auth
 *
 * Handles authorization page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class Auth extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('UserModel');
    }
    
    /**
    * Initializes the login page and validates username and password.
    */
    public function login(){
        $this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[50]');
        if ($this->form_validation->run() == FALSE){
            $this->displayLoginForm();
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if(!$this->isLoginValid($username,$password)) return;
            redirect('user/userList');
        }
    }
    
    /**
    * Returns true if the login credentials are valid and creates session. 
    * It also increment failed_login when credentials are not valid.
    *
    * @param    string  $username   Username string
    * @param    string  $password   Password string
    * @return   boolean
    */
    private function isLoginValid($username,$password){
        $user = $this->UserModel->getUserByUsername($username);
        // Check if the username is valid.
        if(!$user){
            $this->displayLoginForm('Invalid username/password.');
            return false;
        }
        // Check if username is blocked.
        if($user->status == USER_STATUS_BLOCKED){
            echo "User is blocked. Please contact the administrator.";
            return false;
        }
        // Check if the credentials are valid
        $user2 = $this->UserModel->getUserByCred($username,$password);
        if(!$user2){
            // Increment login_failed.
            $this->UserModel->addLoginFailed($user->id);
            // Log user's invalid attempt.
            $this->ActivityModel->saveUserActivity($user->id,"Login Failed");
            if($user->failed_login >= MAX_LOGIN_ATTEMPT - 1){
                // Block User if failed login attempt is reached.
                $this->UserModel->blockUser($user->id);
                echo "User is blocked. Please contact the administrator.";
                return false;
            }
            $rem_attemp = MAX_LOGIN_ATTEMPT - $user->failed_login - 1;
            $this->displayLoginForm("Invalid username/password.<br/> $rem_attemp Remaining attempt/s.");
            return false;
        }
        // Log user successful login.
        $this->ActivityModel->saveUserActivity($user2->id,"Login Success");
        // Reset invalid login attempt.
        $this->UserModel->resetLoginFailed($user->id);
        // Create session
        
        return true;
    }
    
    /**
    * Displays the login form.
    *
    * @param    string  $error_message   Error messages.
    */
    private function displayLoginForm($error_message=NULL){
        $this->load->view('common/header');
        if($error_message){
            $this->load->view('login',array('error_message'=>$error_message));
        }else{
            $this->load->view('login');            
        }
        $this->load->view('common/footer');
    }
}
