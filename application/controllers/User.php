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
        $rowsPerPage = getRowsPerPage($this,COOKIE_USER_ROWS_PER_PAGE);
        $totalCount = $this->UserModel->getUserCount();
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $users = $this->UserModel->getUsers($rowsPerPage,$data['offset']);
        $data['users'] = $users;
        $data['current_uri'] = 'user/userList';
        renderPage($this,$data,'user/userList');
    }
        
    /**
    * Search page.
    */
    public function search(){
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN){
            echo 'Invalid access.';
            return;
        }
        renderPage($this,null,'user/search');        
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
            renderPage($this,$data,'user/searchResult');
            return;
        }
        
        $rowsPerPage = getRowsPerPage($this,COOKIE_USER_SEARCH_ROWS_PER_PAGE);
        $totalCount = $this->UserModel->searchUserCount($searchParams);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $data['shownFields'] = $shownFields;
        $data['columnHeaders'] = $columnHeaders;
        $data['searcParams'] = $searchParams;
        $data['filters'] = generateTextForFilters($searchParams);
        $data['removedRowsPerPage'] = site_url('user/searchResult').'?'.getQueryParams(["rowsPerPage"]);
        $data['removedCurrentPage'] = site_url('user/searchResult').'?'.getQueryParams(["currentPage"]);
        
        if($this->input->get("exportResult")){
            $users = $this->UserModel->searchUser($searchParams,$shownFields,0);
            $this->exportCSV($this->input->get("exportResult"),$users,$columnHeaders);
        }else{
            $users = $this->UserModel->searchUser($searchParams,$shownFields,$rowsPerPage,$data['offset']);
        }
        $data['users'] = $users;
        renderPage($this,$data,'user/searchResult');
    }
    
    /**
    * Export search result to CSV file.
    */
   private function exportCSV($filename,$data,$header){ 
        // file name 
        $filename = $filename.'.csv'; 
        header("Content-Description: File Transfer"); 
        header("Content-Disposition: attachment; filename=$filename"); 
        header("Content-Type: application/csv; ");

        // file creation 
        $file = fopen('php://output', 'w');

        fputcsv($file, $header);
        foreach ($data as $key=>$line){
            // Remove ID
            unset($line['id']);
            fputcsv($file,$line); 
        }
        fclose($file); 
        exit; 
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
            if($condition == CONDITION_FROM){
                return (object) [
                    'field' => $field,
                    'condition' => $condition,
                    'value' => $value,
                    'value_2' => $value2 ? $value2 : date('Y-m-d'),
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
        renderPage($this,$data,'user/detailsView');
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
        renderPage($this,$data,'user/detailsView');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Updated user ".$user->username." details.");
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
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Deleted user.");
        echo 'Success';
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
            renderPage($this,$data,'user/add');
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
        renderPage($this,$data,'user/add');
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Created user ".$user->username.".");
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
        renderPage($this,$data,'user/profile');
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
            // Log user activity.
            $this->ActivityModel->saveUserActivity(
                    $userId, "Updated profile.");
        }
        // Display form.
        $data["user"] = $user;
        renderPage($this,$data,'user/profile');
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
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Blocked user.");
        echo 'Success';
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
        if(!$success){
            echo 'Error';
            return;
        }
        // Log user activity.
        $this->ActivityModel->saveUserActivity(
                $this->session->userdata(SESS_USER_ID),
                "Activated user.");
        echo 'Success';
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
            renderPage($this,$data,'user/updatePassword');
            return;
        }
        
        $userId = $this->session->userdata(SESS_USER_ID);
        // Check if current password is correct.
        $user = $this->UserModel->getUserById($userId);
        if(!password_verify($password,$user->password)){
            $data["error_message"] = "Incorrect password.";
            renderPage($this,$data,'user/updatePassword');
            return;            
        }
        
        // Update user password.
        $success = $this->UserModel->updateUserPassword($userId,$new_password);
        if(!$success){
            $data["error_message"] = "Error occured";
        }else{
            $data["success_message"] = "Password successfully changed.";
            // Log user activity.
            $this->ActivityModel->saveUserActivity(
                    $userId, "Changed password.");
        }
        renderPage($this,$data,'user/updatePassword');        
    }
    
    /**
    * Display user logs.
    */
    public function log(){
        $userId = $this->input->get("userId") ? $this->input->get("userId") : 
            $this->session->userdata(SESS_USER_ID);
        if($this->session->userdata(SESS_USER_ROLE)!=USER_ROLE_ADMIN && 
                $userId != $this->session->userdata(SESS_USER_ID)){
            echo 'Invalid access.';
            return;
        }
        $rowsPerPage = getRowsPerPage($this,COOKIE_ACTIVITY_ROWS_PER_PAGE);
        $totalCount = $this->ActivityModel->getUserActivityCount($userId);
        // Current page is set to 1 if currentPage is not in URL.
        $currentPage = $this->input->get('currentPage') 
                ? $this->input->get('currentPage') : 1;
        $data = setPaginationData($totalCount,$rowsPerPage,$currentPage);
        $activities = $this->ActivityModel->getUserActivities($userId,
                $rowsPerPage,$data['offset']);
        if($activities === -1){
            $data["error_message"] = "Error occured";
            return;
        }
        $data["activities"] = $activities;
        renderPage($this,$data,'user/log');
    }
}
