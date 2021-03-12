<?php

class ApplicantAuth_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ApplicantSeeder');
    }
    
    public function test_loginAsApplicant(){
        // Login as admin
        $this->request(
            'POST',
            'applicantAuth/login',
            [
                'email' => 'steven@test.com',
                'password' => 'hello',
            ]
        );
        
        // Check if admin successfully logged in.
        $this->assertRedirect('dashboard/applicantOverview', 302);
    }
    
    public function test_invalidLoginCred(){
        $output = $this->request(
            'POST',
            'applicantAuth/login',
            [
                'email' => 'steven@test.com',
                'password' => 'hellopw',
            ]
        );
        $this->assertContains('Invalid email/password', $output);
    }
    
    public function test_blockedApplicant(){
        $data = array(
            'email' => 'applicant@test.com',
            'password' => 'hellopw',
        );
        for ($ctr = 0; $ctr <= 5; $ctr++) {
            $output = $this->request(
                'POST',
                'applicantAuth/login',
                $data
            );
        }
        
        $this->assertContains('Applicant is blocked. Please contact the administrator.', $output);
    }
    
    public function test_noEmail(){
        $output = $this->request(
            'POST',
            'applicantAuth/login',
            [
                'password' => 'hello',
            ]
        );
        $this->assertContains('The Email field is required.', $output);
    }
    
    public function test_noPassword(){
        $output = $this->request(
            'POST',
            'applicantAuth/login',
            [
                'email' => 'applicant@test.com',
            ]
        );
        $this->assertContains('The Password field is required.', $output);
    }
    
    public function test_logout(){
        $this->request(
            'POST',
            'applicantAuth/login',
            [
                'email' => 'steven@test.com',
                'password' => 'hello',
            ]
        );
        $this->assertRedirect('dashboard/applicantOverview', 302);
        $this->request('GET','applicantAuth/logout');
        $this->assertRedirect('applicantAuth/login', 302);
    }

    public function test_method_404(){
        $this->request('GET', 'welcome/method_not_exist');
        $this->assertResponseCode(404);
    }
    
    public function test_redirectToReferrer(){
        $this->request(
            'POST',
            'applicantAuth/login',
            [
                'email' => 'steven@test.com',
                'password' => 'hello',
                'referrer' => 'test/page',
            ]
        );
        $this->assertRedirect('test/page', 302);
    }
}
