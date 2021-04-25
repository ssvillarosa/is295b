<?php

class AdminDashboard_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('JobOrderSeeder');
        $CI->seeder->call('ApplicantSeeder');
        $CI->seeder->call('PipelineSeeder');
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
    
    public function test_getAssignedToMe(){
        $output = $this->request('GET','admin_dashboard/getAssignedToMe');
        $this->assertContains('Steven Villarosa', $output);
        $this->assertContains('Software Developer', $output);
        $this->assertContains('Theresa San Jose', $output);
    }
    
    public function test_getJoAssignedToMe(){
        $output = $this->request('GET','admin_dashboard/getJoAssignedToMe');
        $this->assertContains('Software Developer', $output);
    }
}