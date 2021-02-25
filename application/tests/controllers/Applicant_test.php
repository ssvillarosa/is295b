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
}