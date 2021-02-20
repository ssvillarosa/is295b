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
        $this->assertContains('id="company-1"', $page1);
        $this->assertNotContains('id="company-2"', $page1);
        
        $page2 = $this->request('GET','company/companyList?rowsPerPage=1&currentPage=2');
        $rowCount = substr_count($page2,'company-row-item');
        $this->assertEquals(1, $rowCount);
        $this->assertContains('id="company-2"', $page2);
        $this->assertNotContains('id="company-1"', $page2);
        
        $newPage = $this->request('GET','company/companyList?rowsPerPage=3');
        $rowCount = substr_count($newPage,'company-row-item');
        $this->assertEquals(3, $rowCount);
    }
    
    public function test_view(){
        $page = $this->request('GET','company/view?id=1');
        $this->assertContains('ABC Corp', $page);
        $this->assertContains('Steven Suanuqe', $page);
    }
    
    public function test_update(){
        $postData = [
            'companyId' => '2',
            'name' => 'UpdatedTest',
            'contact_person' => 'Updated Contact',
            'primary_phone' => '1111',
            'secondary_phone' => '2222',
            'address' => 'Updated Address',
            'website' => 'www.updated-webiste.com',
            'industry' => 'Updated Industry',
        ];
        $success = $this->request(
            'POST',
            'company/update',
            $postData
        );
        $this->assertContains('Company successfully updated!', $success);
        $page = $this->request('GET','company/view?id=2');
        $this->assertContains($postData['name'], $page);
        $this->assertContains($postData['contact_person'], $page);
        $this->assertContains($postData['primary_phone'], $page);
        $this->assertContains($postData['secondary_phone'], $page);
        $this->assertContains($postData['address'], $page);
        $this->assertContains($postData['website'], $page);
        $this->assertContains($postData['industry'], $page);
    }
    
    public function test_add(){
        $postData = [
            'name' => 'New Company',
            'contact_person' => 'Newly Created',
            'primary_phone' => '1111',
            'secondary_phone' => '2222',
            'address' => 'New Address',
            'website' => 'www.new-webiste.com',
            'industry' => 'New Industry',
        ];
        $success = $this->request(
            'POST',
            'company/add',
            $postData
        );
        $this->assertContains('Company successfully added!', $success);
    }
    
    public function test_search(){
        $output = $this->request('GET','user/searchResult?condition_name=E&value_name=BBS&display_name=on');
        $this->assertContains('BBS', $output);
    }
    
    public function test_delete(){
        // Add company.
        $postData = [
            'name' => 'DelCompany',
        ];
        $success = $this->request(
            'POST',
            'company/add',
            $postData
        );
        $this->assertContains('Company successfully added!', $success);
        // Confirm if company is added.
        $output = $this->request('GET','user/searchResult?condition_name=E&value_name=DelCompany&display_name=on');
        $this->assertContains('DelCompany', $output);
        // Delete company.
        $delPostData = [
            'delCompanyIds' => '6',
        ];
        $delSuccess = $this->request(
            'POST',
            'company/delete',
            $delPostData
        );
        $this->assertContains('Success', $delSuccess);
        // Confirm if company is deleted.
        $output = $this->request('GET','user/searchResult?condition_name=E&value_name=DelCompany&display_name=on');
        $this->assertContains('DelCompany', $output);
    }
}