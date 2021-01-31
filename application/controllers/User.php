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
        $rowsPerPage = $this->getRowsPerPage();
        $totalCount = $this->UserModel->getUserCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = $this->setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $users = $this->UserModel->getUsers($rowsPerPage,$data['offset']);
        $data['users'] = $users;
        $data['current_uri'] = 'user/userList';
        $this->displayView($data,'user/userList');
    }
  
    /**
    * Returns the value of rows per page.
    * 
    * @return   int value
    */
    private function getRowsPerPage(){        
        // Default rows per page(25) is set if rowsPerPage is not changed.
        $rowsPerPage = $this->input->cookie(COOKIE_USER_ROWS_PER_PAGE)?
                $this->input->cookie(COOKIE_USER_ROWS_PER_PAGE) : 25;
        // If user changes the number of rows per page, store it into cookie
        if($this->input->get('rowsPerPage')){
            set_cookie(COOKIE_USER_ROWS_PER_PAGE, $this->input->get('rowsPerPage'),
                    COOKIE_EXPIRATION);
            $rowsPerPage = $this->input->get('rowsPerPage');
        }
        return $rowsPerPage;
    }
    
    /**
    * Creates pagination data.
    * 
    * @param    int  $totalCount    The total number of users in the database.   
    * @param    int  $rowsPerPage   The number of users per page.
    * @param    int  $currentPage   The active page.
    * @return   object(field,condition,value[,value_2])
    */
    private function setPaginationData($totalCount,$rowsPerPage,$currentPage){        
        $totalPage = floor($totalCount/$rowsPerPage);
        if($totalCount%$rowsPerPage != 0){
            $totalPage++;
        }
        $offset = ($currentPage - 1) * $rowsPerPage;
        $data['totalPage'] = $totalPage;
        $data['rowsPerPage'] = $rowsPerPage;
        $data['currentPage'] = $currentPage;
        $data['totalCount'] = $totalCount;
        $data['offset'] = $offset;
        return $data;
    }
        
    /**
    * Search page.
    */
    public function search(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $this->displayView(null,'user/search');        
    }
    
    /**
    * Search results page.
    */
    public function searchResult(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        // Create search parameters for each field.
        $searchParams = [];
        $fields = [
            "username",
            "role",
            "status",
            "name",
            "email",
            "contact_number",
            "birthday",
            "address"];
        foreach ($fields as $field){
            $param = $this->getSearchParam($field);
            $param ? array_push($searchParams, $param):'';            
        }
        
        // Create array to store fields to be shown
        $shownFields = [];
        // Create column header for the table.
        $columnHeaders = [];
        foreach ($searchParams as $param){
            if($param->show){
                array_push($shownFields, $param->field);   
                array_push($columnHeaders, ucwords(str_replace("_", " ", $param->field)));   
            }
        }
        if(!$shownFields){
            $data['error_message'] = "Select at least one field to be displayed.";
            $this->displayView($data,'user/searchResult');
            return;
        }
        
        $rowsPerPage = $this->getRowsPerPage();
        $totalCount = $this->UserModel->searchUserCount($searchParams);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = $this->setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $users = $this->UserModel->searchUser($searchParams,$shownFields,$rowsPerPage,$data['offset']);
        $data['users'] = $users;
        $data['shownFields'] = $shownFields;
        $data['columnHeaders'] = $columnHeaders;
        $data['removedRowsPerPage'] = site_url('user/searchResult').'?'.getQueryParams(["rowsPerPage"]);
        $data['removedCurrentPage'] = site_url('user/searchResult').'?'.getQueryParams(["currentPage"]);
        $this->displayView($data,'user/searchResult');
    }
    
    /**
    * Creates searchParameter object out of get input.
    * 
    * @param    string  $field  The field to create the search param.           
    * @return   object(field,condition,value[,value_2])
    */
    private function getSearchParam($field){
        if($this->input->get("condition_$field") && 
                $this->input->get("value_$field")){
            $condition = strval($this->input->get("condition_$field"));
            $value = strval($this->input->get("value_$field"));
            $value2 = strval($this->input->get("value_{$field}_2"));
            $show = $this->input->get("display_$field")? true: false;
            // For date fields with F condition.
            if($value2){
                return (object) [
                    'field' => $field,
                    'condition' => $condition,
                    'value' => $value,
                    'value_2' => $value2,
                    'show' => $show,
                  ];                
            }
            return (object) [
                'field' => $field,
                'condition' => $condition,
                'value' => $value,
                'show' => $show,
              ];
        }
        if($this->input->get("display_$field")){
            $show = $this->input->get("display_$field")? true: false;
            return (object) [
                'field' => $field,
                'show' => $show,
              ];
        }
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
        $this->displayView($data,'user/detailsView');
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
        $this->displayView($data,'user/detailsView');
    }
    
    /**
    * Delete user.
    */
    public function delete(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        if(!$this->input->post('delUserIds')){
            echo 'Invalid User ID';
            return;
        }
        $userIds = explode(",", $this->input->post('delUserIds'));
        $success = $this->UserModel->deleteUser($userIds);
        echo ($success ? 'Success' : 'Error');
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
            $this->displayView($data,'user/add');
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
        $this->displayView($data,'user/add');
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
    private function displayView($data,$form){
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
        $this->displayView($data,'user/profile');
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
        $this->displayView($data,'user/profile');
    }
        
    /**
    * Blocks user account.
    */
    public function block(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $userId = $this->input->post('userId');
        $success = $this->UserModel->blockUser($userId);
        echo $success ? 'Success':'Error';
    }
        
    /**
    * Activates user account.
    */
    public function activate(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        $userId = $this->input->post('userId');
        $success = $this->UserModel->activateUser($userId);
        echo $success ? 'Success':'Error';
    }
     
    /**
    * Changes user password.
    */
    public function changePassword(){
        $this->form_validation->set_rules('password', 'Password',
                'trim|required|max_length[50]');
        $this->form_validation->set_rules('new_password', 'Password',
                'trim|required|max_length[50]');
        $this->form_validation->set_rules('confirm_password', 
                'Password Confirmation', 'required|matches[new_password]');
        $password = $this->input->post('password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');
        $data["password"] = $password;
        $data["new_password"] = $new_password;
        $data["confirm_password"] = $confirm_password;
        if (!$this->form_validation->run()){
            $this->displayView($data,'user/updatePassword');
            return;
        }
        
        $userId = $this->session->userdata(SESS_USER_ID);
        // Check if current password is correct.
        $user = $this->UserModel->getUserById($userId);
        if(!password_verify($password,$user->password)){
            $data["error_message"] = "Incorrect password.";
            $this->displayView($data,'user/updatePassword');
            return;            
        }
        
        // Update user password.
        $success = $this->UserModel->updateUserPassword($userId,$new_password);
        if(!$success){
            $data["error_message"] = "Error occured";
        }else{
            $data["success_message"] = "Password successfully changed.";
        }
        $this->displayView($data,'user/updatePassword');        
    }
}
