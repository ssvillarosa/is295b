<?php

class User_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('UserSeeder');
    }
    
    public function setUp(){        
        // Login as admin.
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'admin',
                'password' => 'adminpw',
            ]
        );
    }
    
    public function test_userList(){
        $output = $this->request('GET','user/userList');
        $this->assertContains('id="user-1"', $output);
        $this->assertContains('id="user-2"', $output);
        $this->assertContains('id="user-3"', $output);
    }
    
    public function test_view(){
        $output = $this->request('GET','user/view?id=1');
        $this->assertContains('<h5 class="mb-3">Username: admin</h5>', $output);
    }
    
    public function test_addValidations(){
        // Check validations.
        $validationCheck = $this->request(
            'POST',
            'user/add',
            [
                'username' => '',
                'password' => '',
                'confirm_password' => '',
                'role' => '',
                'status' => '',
                'email' => '',
                'contact_number' => '',
                'name' => '',
                'address' => '',
                'birthday' => '',
            ]
        );
        $this->assertContains('The Username field is required.', $validationCheck);
        $this->assertContains('The Password field is required.', $validationCheck);
        $this->assertContains('The Password Confirmation field is required.', $validationCheck);
        $this->assertContains('The Role field is required.', $validationCheck);
        $this->assertContains('The Name field is required.', $validationCheck);
        $this->assertContains('The Email field is required.', $validationCheck);
    }
    
    public function test_addUserExist(){
        // Add existing username.
        $usernameExist = $this->request(
            'POST',
            'user/add',
            [
                'username' => 'admin',
                'password' => 'adminpw',
                'confirm_password' => 'adminpw',
                'role' => USER_ROLE_ADMIN,
                'status' => USER_STATUS_ACTIVE,
                'email' => 'user4@test.com',
                'contact_number' => '999999',
                'name' => 'User 4',
                'address' => 'Here',
                'birthday' => '1999-03-05',
            ]
        );
        $this->assertContains('Username already exist.', $usernameExist);
    }
    
    public function test_addPasswordMismatch(){
        // Check password mismatch validation
        $passwordMismatch = $this->request(
            'POST',
            'user/add',
            [
                'username' => 'admin2',
                'password' => 'admin2pw',
                'confirm_password' => '0000',
                'role' => USER_ROLE_ADMIN,
                'status' => USER_STATUS_ACTIVE,
                'email' => 'user4@test.com',
                'contact_number' => '999999',
                'name' => 'User 4',
                'address' => 'Here',
                'birthday' => '1999-03-05',
            ]
        );
        $this->assertContains('The Password Confirmation field does not match the Password field.', $passwordMismatch);
    }
    
    public function test_addSuccess(){
        // Add user success.
        $success = $this->request(
            'POST',
            'user/add',
            [
                'username' => 'admin2',
                'password' => 'admin2pw',
                'confirm_password' => 'admin2pw',
                'role' => USER_ROLE_ADMIN,
                'status' => USER_STATUS_ACTIVE,
                'email' => 'user4@test.com',
                'contact_number' => '999999',
                'name' => 'User 4',
                'address' => 'Here',
                'birthday' => '1999-03-05',
            ]
        );
        $this->assertContains('User successfully added!', $success);
    }
    
    public function test_updateDetails(){
        $postData = [
            'userId' => '3',
            'role' => USER_ROLE_ADMIN,
            'status' => USER_STATUS_ACTIVE,
            'email' => 'hello@test.com',
            'contact_number' => '1010101',
            'name' => 'New Year New Mi',
            'address' => 'This is my now',
            'birthday' => '1992-09-23',
        ];
        // Add user success.
        $success = $this->request(
            'POST',
            'user/updateDetails',
            $postData
        );
        $this->assertContains('User successfully updated!', $success);
        $this->assertContains($postData['email'], $success);
        $this->assertContains($postData['contact_number'], $success);
        $this->assertContains($postData['name'], $success);
        $this->assertContains($postData['address'], $success);
        $this->assertContains($postData['birthday'], $success);
    }
    
    public function test_profile(){   
        // Login as admin.
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'admin',
                'password' => 'adminpw',
            ]
        );
        // Check user profile.
        $output = $this->request(
            'GET',
            'user/profile'
        );
        $this->assertContains('Super Admin', $output);
        $this->assertContains('admin@test.com', $output);
        $this->assertContains('999999', $output);
        $this->assertContains('1990-01-01', $output);
        $this->assertContains('CPU', $output);
    }
    
    public function test_profileUpdate(){   
        // Login as Guest.
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'guest',
                'password' => 'guestpw',
            ]
        );
        // Update profile.
        $this->request(
            'POST',
            'user/profileUpdate',
            [
                'name' => 'Profile Update Guest',
                'email' => 'updatedguest@test.com',
                'contact_number' => '321',
                'birthday' => '1993-10-03',
                'address' => 'CRN',
            ]
        );
        
        // Check user profile.
        $output = $this->request(
            'GET',
            'user/profile'
        );
        $this->assertContains('Profile Update Guest', $output);
        $this->assertContains('updatedguest@test.com', $output);
        $this->assertContains('321', $output);
        $this->assertContains('1993-10-03', $output);
        $this->assertContains('CRN', $output);
    }
    
    public function test_block(){   
        // Login as Guest.
        $output = $this->request(
            'POST',
            'user/block',
            [
                'userId' => 3,
            ]
        );
        $this->assertContains('Success', $output);
    }
    
    public function test_activates(){   
        // Login as Guest.
        $output = $this->request(
            'POST',
            'user/activate',
            [
                'userId' => 3,
            ]
        );
        $this->assertContains('Success', $output);
    }
}
