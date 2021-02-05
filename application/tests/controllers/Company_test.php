<?php

class Company_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('CompanySeeder');
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
    
    public function test_companyList(){
        $output = $this->request('GET','company/companyList');
        $this->assertContains('id="company-1"', $output);
        $this->assertContains('id="company-2"', $output);
        $this->assertContains('id="company-3"', $output);
    }
    
    public function test_userListPagination(){
        $page1 = $this->request('GET','company/companyList?rowsPerPage=1');
        $rowCount = substr_count($page1,'company-row-item');
        $this->assertEquals(1, $rowCount);
        $this->assertContains('id="company-1"', $output);
        $this->assertNotContains('id="company-2"', $output);
        
        $page2 = $this->request('GET','company/companyList?rowsPerPage=1&currentPage=2');
        $rowCount = substr_count($page2,'company-row-item');
        $this->assertEquals(1, $rowCount);
        $this->assertContains('id="company-2"', $output);
        $this->assertNotContains('id="company-1"', $output);
        
        $newPage = $this->request('GET','company/companyList?rowsPerPage=3');
        $rowCount = substr_count($newPage,'company-row-item');
        $this->assertEquals(3, $rowCount);
    }
}