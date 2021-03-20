<?php

class Pipeline_test extends TestCase{
    
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
    
    public function test_applicantPipelinePage(){
        $output = $this->request('GET','pipeline/getApplicantsByJobOrder?job_order_id=1');
        $this->assertContains('Steven Villarosa', $output);
        $this->assertContains('Theresa San Jose', $output);
    }
}
