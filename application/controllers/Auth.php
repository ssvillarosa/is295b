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
        $this->form_validation->set_rules('username', 'Username',
                'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password',
                'trim|required|max_length[50]');
        if ($this->form_validation->run() == FALSE){
            $this->displayLoginForm();
        }else{
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if(!$this->isLoginValid($username,$password)) return;
            // Get the referrer parameter.
            $loginReferrer = $this->input->post('referrer');
            // Redirect to referrer URL.
            if($loginReferrer){
                redirect($loginReferrer);
                return;              
            }
            // Otherwise, redirect to homepage.
            redirect('dashboard/adminOverview');
        }
    }
    
    /**
    * Destroys session and redirects user to login page.
    */
    public function logout(){
        $this->UserLogModel->saveUserLog(
                $this->session->userdata(SESS_USER_ID),"Logged out.");
        $sessionData = array(
            SESS_USER_ID,
            SESS_USERNAME,
            SESS_USER_ROLE,
            SESS_USER_EMAIL,
            SESS_USER_FULL_NAME,
            SESS_IS_LOGGED_IN
        );
        $this->session->unset_userdata($sessionData);
        redirect('auth/login');
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
        // Check if password is correct
        if(!password_verify($password,$user->password)){
            // Increment login_failed.
            $this->UserModel->addLoginFailed($user->id);
            // Log user's invalid attempt.
            $this->UserLogModel->saveUserLog($user->id,"Login Failed.");
            if($user->failed_login >= MAX_LOGIN_ATTEMPT - 1){
                // Block User if failed login attempt is reached.
                $this->UserModel->blockUser($user->id);
                echo "User is blocked. Please contact the administrator.";
                return false;
            }
            $rem_attemp = MAX_LOGIN_ATTEMPT - $user->failed_login - 1;
            $this->displayLoginForm("Invalid username/password.<br/> $rem_attemp"
                    . " Remaining attempt/s.");
            return false;
        }
        // Log user successful login.
        $this->UserLogModel->saveUserLog($user->id,"Login Success.");
        // Reset invalid login attempt.
        $this->UserModel->resetLoginFailed($user->id);
        // Create user session
        $this->createSession($user);
        return true;
    }
    
     /**
    * Creates user session.
    *
    * @param    string  $user   User object.
    */
    private function createSession($user){
        $sessionData = array(
            SESS_USER_ID        => $user->id,
            SESS_USERNAME       => $user->username,
            SESS_USER_ROLE      => $user->role,
            SESS_USER_EMAIL     => $user->email,
            SESS_USER_FULL_NAME => $user->name,
            SESS_IS_LOGGED_IN   => TRUE
        );
        $this->session->set_userdata($sessionData);
        // TODO: Store session ID in cookie to resume later.
    }
    
    /**
    * Displays the login form.
    *
    * @param    string  $error_message   Error messages.
    */
    private function displayLoginForm($error_message=NULL){
        $this->load->view('auth/header');
        // On the first load, referrer url will be read from GET request.
        // Referrer value will be embedded into hidden field.
        // This will include the referrer url to a form for POST request.
        $referrer = $this->input->get_post('referrer');
        $data = array();
        if($error_message){
            $data["error_message"]=$error_message;
        }
        if($referrer){
            $data["login_referrer"]=$referrer;
        }
        $data["username"] = $this->input->get_post('username');
        $data["password"] = $this->input->get_post('password');
        $this->load->view('auth/login',$data);
        $this->load->view('common/footer');
    }
}
