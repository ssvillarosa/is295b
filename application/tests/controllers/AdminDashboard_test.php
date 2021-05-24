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
        $CI->seeder->call('EventSeeder');
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
    
    public function test_getUnassigned(){
        // Submit application tru applicant account.
        $this->request(
            'POST',
            'applicantAuth/login',
            [
                'email' => 'steven@test.com',
                'password' => 'hello',
            ]
        );
        $filename = 'test.docx';
        $filepath = APPPATH.'tests/testfiles/'.$filename;
        $files = [
                'file_attachment' => [
                        'name'     => $filename,
                        'tmp_name' => $filepath,
                ],
        ];
        $this->request->setFiles($files);
        $result = $this->request(
            'POST',
            'pipeline/applicantSubmitAjax',
            [
                'job_order_id' => 3,
            ]
        );
        $this->assertContains('Success', $result);
        // Check submission
        $output = $this->request('GET','admin_dashboard/getUnassigned');
        $this->assertContains('Steven Villarosa', $output);
        $this->assertContains('Quality Assurance', $output);
    }
    
    public function test_getEvents(){
        $output = $this->request('GET','admin_dashboard/getEvents');
        $this->assertContains('Event 3', $output);
    }
    
    public function test_getPublicEvents(){
        $output = $this->request('GET','admin_dashboard/getPublicEvents');
        $this->assertContains('Event 2', $output);
    }
}