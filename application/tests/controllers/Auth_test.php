<?php

class Auth_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('UserSeeder');
    }
    
    public function test_login(){
        // Login as admin
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'admin',
                'password' => 'adminpw',
            ]
        );
        
        // Check if admin successfully logged in.
        $this->assertRedirect('dashboard/overview', 302);
        
        // Check if admin can access user module.
        $adminPage = $this->request('GET', 'user/userList');
        $this->assertContains('admin-only', $adminPage);
        $this->request('GET','auth/logout');
        
        // Login as recruiter
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'steven',
                'password' => 'stevenpw',
            ]
        );
        $this->assertRedirect('dashboard/overview', 302);
        $recruiterPage = $this->request('GET', 'user/userList');
        $this->assertNotContains('admin-only', $recruiterPage);
    }
    
    public function test_invalidLoginCred(){
        $output = $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'admin',
                'password' => 'admin',
            ]
        );
        $this->assertContains('Invalid username/password', $output);
    }
    
    public function test_blockedUser(){
        $data = array(
            'username' => 'guest',
            'password' => 'guest',
        );
        for ($ctr = 0; $ctr <= 5; $ctr++) {
            $output = $this->request(
                'POST',
                'auth/login',
                $data
            );
        }
        
        $this->assertContains('User is blocked. Please contact the administrator.', $output);
    }
    
    public function test_noUsername(){
        $output = $this->request(
            'POST',
            'auth/login',
            [
                'password' => 'admin',
            ]
        );
        $this->assertContains('The Username field is required.', $output);
    }
    
    public function test_noPassword(){
        $output = $this->request(
            'POST',
            'auth/login',
            [
                'password' => 'admin',
            ]
        );
        $this->assertContains('The Username field is required.', $output);
    }
    
    public function test_logout(){
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'steven',
                'password' => 'stevenpw',
            ]
        );
        $this->assertRedirect('dashboard/overview', 302);
        $this->request('GET','auth/logout');
        $this->assertRedirect('auth/login', 302);
    }
    
    public function test_redirectToReferrer(){
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'admin',
                'password' => 'adminpw',
                'referrer' => 'user/userList',
            ]
        );
        $this->assertRedirect('user/userList', 302);
    }

    public function test_method_404(){
        $this->request('GET', 'welcome/method_not_exist');
        $this->assertResponseCode(404);
    }

    public function test_APPPATH(){
        $actual = realpath(APPPATH);
        $expected = realpath(__DIR__ . '/../..');
        $this->assertEquals(
            $expected,
            $actual,
            'Your APPPATH seems to be wrong. Check your $application_folder in tests/Bootstrap.php'
        );
    }
}
