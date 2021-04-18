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
    
    public function test_applicantPipelineTable(){
        $output = $this->request('GET','pipeline/applicantPipelineTable?job_order_id=1');
        $this->assertContains('Steven Villarosa', $output);
        $this->assertContains('Theresa San Jose', $output);
        $this->assertContains('Add Candidate', $output);
    }
    
    public function test_jobOrderPipelineTable(){
        $output = $this->request('GET','pipeline/jobOrderPipelineTable?applicant_id=1');
        $this->assertContains('Software Developer', $output);
    }
    
    public function test_userNoAccess(){
        // Login as updateProfTest.
        $login = $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'steven',
                'password' => 'stevenpw',
            ]
        );
        $output = $this->request('GET','pipeline/applicantPipelineTable?job_order_id=1');
        $this->assertContains('Steven Villarosa', $output);
        $this->assertContains('Theresa San Jose', $output);
        $this->assertNotContains('>Add Candidate<', $output);
    }
    
    public function test_add(){
        $output = $this->request(
            'POST',
            'pipeline/add',
            [
                'job_order_id' => '2',
                'applicant_id' => '3',
                'assigned_to' => '1',
            ]
        );
        $this->assertContains('Success', $output);
    }
    
    public function test_delete(){
        $output = $this->request(
            'POST',
            'pipeline/add',
            [
                'job_order_id' => '2',
                'applicant_id' => '1',
                'assigned_to' => '2',
            ]
        );
        $this->assertContains('Success', $output);
        $output = $this->request(
            'POST',
            'pipeline/delete',
            [
                'delPipelineIds' => '6',
            ]
        );
        $this->assertContains('Success', $output);
    }
    
    public function test_applicantSubmitAjax(){
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
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 7,
            ]
        );
        $this->assertContains('Job Order Title: Quality Assurance', $page);
        $this->assertContains('Candidate Full Name: Steven Villarosa', $page);
        $this->assertContains('test.docx', $page);
    }
}
