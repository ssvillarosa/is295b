<?php

class Applicant_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ApplicantSeeder');
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
    
    public function test_applicantList(){
        $output = $this->request('GET','applicant/applicantList');
        $this->assertContains('id="applicant-1"', $output);
        $this->assertContains('id="applicant-2"', $output);
        $this->assertContains('id="applicant-3"', $output);
    }
    
    public function test_applicantListPagination(){
        $page1 = $this->request('GET','applicant/applicantList?rowsPerPage=1');
        $rowCount = substr_count($page1,'applicant-row-item');
        $this->assertEquals(1, $rowCount);
        $this->assertContains('id="applicant-1"', $page1);
        $this->assertNotContains('id="applicant-2"', $page1);
        
        $page2 = $this->request('GET','applicant/applicantList?rowsPerPage=1&currentPage=2');
        $rowCount = substr_count($page2,'applicant-row-item');
        $this->assertEquals(1, $rowCount);
        $this->assertContains('id="applicant-2"', $page2);
        $this->assertNotContains('id="applicant-1"', $page2);
        
        $newPage = $this->request('GET','applicant/applicantList?rowsPerPage=3');
        $rowCount = substr_count($newPage,'applicant-row-item');
        $this->assertEquals(3, $rowCount);
    }
    
    public function test_view(){
        $page = $this->request('GET','applicant/view?id=1');
        $this->assertContains('value="Villarosa"', $page);
        $this->assertContains('value="Steven"', $page);
    }
    
    public function test_update(){
        $postData = [
            'applicantId' => '2',
            'last_name' => 'Controller',
            'first_name' => 'TestUpdate',
            'email' => 'testupdatecontroller@test.com',
            'primary_phone' => '0000',
            'secondary_phone' => '1122',
            'work_phone' => '2233',
            'address' => 'Somewhere over the rainbow',
            'best_time_to_call' => '3AM',
            'source' => 'Neverland',
            'current_employer' => 'DreamLand',
            'can_relocate' => '0',
            'current_pay' => '',
            'desired_pay' => '',
            'skillIds' => '1,3,4',
            'skillNames' => 'Javascript,Go,Indexing',
            'yearsOfExperiences' => '8,6,5',
        ];
        $this->request('POST','applicant/update',$postData);
        $output = $this->request('GET','applicant/view?id=2');
        $this->assertContains('value="Controller"', $output);
        $this->assertContains('value="TestUpdate"', $output);
        $this->assertContains('value="testupdatecontroller@test.com"', $output);
        $this->assertContains('value="0000"', $output);
        $this->assertContains('value="1122"', $output);
        $this->assertContains('value="2233"', $output);
        $this->assertContains('value="Somewhere over the rainbow"', $output);
        $this->assertContains('value="3AM"', $output);
        $this->assertContains('value="Neverland"', $output);
        $this->assertContains('value="DreamLand"', $output);
        $this->assertNotContains('checked', $output);
        $this->assertContains("'skill-1'", $output);
        $this->assertContains("'skill-4'", $output);
        $this->assertNotContains("'skill-2'", $output);
    }
    
     public function test_add(){
        $postData = [
            'last_name' => 'Controller',
            'first_name' => 'TestAdd',
            'email' => 'testaddcontroller@test.com',
            'primary_phone' => '0000',
            'secondary_phone' => '1122',
            'work_phone' => '2233',
            'address' => 'Somewhere over the rainbow',
            'best_time_to_call' => '3AM',
            'source' => 'Neverland',
            'current_employer' => 'DreamLand',
            'can_relocate' => '0',
            'current_pay' => '',
            'desired_pay' => '',
            'skillIds' => '1,3,4',
            'skillNames' => 'Javascript,Go,Indexing',
            'yearsOfExperiences' => '8,6,5',
        ];
        $output = $this->request('POST','applicant/add',$postData);
        $this->assertContains('Candidate successfully added!', $output);
    }
    
    public function test_delete(){
        // Add applicant.
        $postData = [
            'last_name' => 'Del',
            'first_name' => 'Del',
            'email' => 'del@test.com',
            'primary_phone' => '0000',
            'secondary_phone' => '1122',
            'work_phone' => '2233',
            'address' => 'Somewhere over the rainbow',
            'best_time_to_call' => '3AM',
            'source' => 'Neverland',
            'current_employer' => 'DreamLand',
            'can_relocate' => '0',
            'current_pay' => '',
            'desired_pay' => '',
            'skillIds' => '1,3,4',
            'skillNames' => 'Javascript,Go,Indexing',
            'yearsOfExperiences' => '8,6,5',
        ];
        $output = $this->request('POST','applicant/add',$postData);
        $this->assertContains('Candidate successfully added!', $output);
        
        $page1 = $this->request('GET','applicant/applicantList');
        $rowCount = substr_count($page1,'applicant-row-item');
        // Delete company.
        $delPostData = [
            'delApplicantIds' => '6',
        ];
        $delSuccess = $this->request(
            'POST',
            'applicant/delete',
            $delPostData
        );
        $this->assertContains('Success', $delSuccess);
        $page2 = $this->request('GET','applicant/applicantList');
        $newCount = substr_count($page2,'applicant-row-item');
        $this->assertEquals($rowCount-1,$newCount);
    }
}