<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ApplicantAuth
 *
 * Handles authorization page.
 * 
 * @category    Controller
 * @author      Steven Villarosa
 */
class ApplicantAuth extends CI_Controller {

    /**
    * Class constructor.
    */
    function __construct() {
        parent::__construct();
        $this->load->model('ApplicantModel');
    }
    
    /**
    * Initializes the login page and validates email and password.
    */
    public function login(){
        $this->form_validation->set_rules('email', 'Email',
                'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password',
                'trim|required|max_length[50]');
        if ($this->form_validation->run() == FALSE){
            $this->displayLoginForm();
        }else{
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            if(!$this->isLoginValid($email,$password)) return;
            // Get the referrer parameter.
            $loginReferrer = html_escape($this->input->post('referrer'));
            // Redirect to referrer URL.
            if($loginReferrer){
                redirect($loginReferrer);
                return;              
            }
            // Otherwise, redirect to homepage.
            redirect('applicant_dashboard/recommendations');
        }
    }
    
    /**
    * Destroys session and redirects applicant to login page.
    */
    public function logout(){
        $sessionData = array(
            SESS_APPLICANT_ID,
            SESS_APPLICANT_EMAIL,
            SESS_APPLICANT_LAST_NAME,
            SESS_APPLICANT_FIRST_NAME,
            SESS_IS_APPLICANT_LOGGED_IN
        );
        $this->session->unset_userdata($sessionData);
        redirect(base_url());
    }
    
    /**
    * Returns true if the login credentials are valid and creates session. 
    * It also increment failed_login when credentials are not valid.
    *
    * @param    string  $email      Email string
    * @param    string  $password   Password string
    * @return   boolean
    */
    private function isLoginValid($email,$password){
        $applicant = $this->ApplicantModel->getApplicantByEmail($email);
        // Check if the email is valid.
        if(!$applicant){
            $this->displayLoginForm('Invalid email/password.');
            return false;
        }
        // Check if applicant is blocked.
        if($applicant->status == USER_STATUS_BLOCKED){
            echo "Applicant is blocked. Please contact the administrator.";
            return false;
        }
        // Check if password is correct
        if(!password_verify($password,$applicant->password)){
            // Increment login_failed.
            $this->ApplicantModel->addLoginFailed($applicant->id);
            if($applicant->failed_login >= MAX_LOGIN_ATTEMPT - 1){
                // Block Applicant if failed login attempt is reached.
                $this->ApplicantModel->blockApplicant($applicant->id);
                echo "Applicant is blocked. Please contact the administrator.";
                return false;
            }
            $rem_attemp = MAX_LOGIN_ATTEMPT - $applicant->failed_login - 1;
            $this->displayLoginForm("Invalid email/password.<br/> $rem_attemp"
                    . " Remaining attempt/s.");
            return false;
        }
        // Reset invalid login attempt.
        $this->ApplicantModel->resetLoginFailed($applicant->id);
        // Create applicant session
        $this->createSession($applicant);
        return true;
    }
    
     /**
    * Creates applicant session.
    *
    * @param    string  $applicant   Applicant object.
    */
    private function createSession($applicant){
        $sessionData = array(
            SESS_APPLICANT_ID        => $applicant->id,
            SESS_APPLICANT_EMAIL       => $applicant->email,
            SESS_APPLICANT_LAST_NAME      => $applicant->last_name,
            SESS_APPLICANT_FIRST_NAME     => $applicant->first_name,
            SESS_IS_APPLICANT_LOGGED_IN   => TRUE,
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
        $referrer = html_escape($this->input->get_post('referrer'));
        $data = array();
        if($error_message){
            $data["error_message"]=$error_message;
        }
        if($referrer){
            $data["login_referrer"]=$referrer;
        }
        $data["email"] = html_escape($this->input->get_post('email'));
        $data["password"] = html_escape($this->input->get_post('password'));
        $this->load->view('applicant_auth/login',$data);
        $this->load->view('common/footer');
    }
}
