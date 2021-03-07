<?php

class Registration_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('RegistrationSeeder');
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
    
    public function test_registrationList(){
        $output = $this->request('GET','registration/registrationList');
        $this->assertContains('id="registration-1"', $output);
        $this->assertContains('id="registration-2"', $output);
        $this->assertContains('id="registration-3"', $output);
    }
    
    public function test_registrationListPagination(){
        $page1 = $this->request('GET','registration/registrationList?rowsPerPage=1');
        $rowCount = substr_count($page1,'registration-row-item');
        $this->assertEquals(1, $rowCount);
        $this->assertContains('id="registration-1"', $page1);
        $this->assertNotContains('id="registration-2"', $page1);
        
        $page2 = $this->request('GET','registration/registrationList?rowsPerPage=1&currentPage=2');
        $rowCount = substr_count($page2,'registration-row-item');
        $this->assertEquals(1, $rowCount);
        $this->assertContains('id="registration-2"', $page2);
        $this->assertNotContains('id="registration-1"', $page2);
        
        $newPage = $this->request('GET','registration/registrationList?rowsPerPage=3');
        $rowCount = substr_count($newPage,'registration-row-item');
        $this->assertEquals(3, $rowCount);
    }
    
    public function test_view(){
        $page = $this->request('GET','registration/view?id=1');
        $this->assertContains('value="RegistrationVillarosa"', $page);
        $this->assertContains('value="Steven"', $page);
    }
    
    public function test_approve(){
        $postData = [
            'approveRegistrationIds' => '1',
        ];
        $output = $this->request('POST','registration/approve',$postData);
        $this->assertEquals($output,'Success');
    }
    
     public function test_register(){
        $postData = [
            'last_name' => 'Controller',
            'first_name' => 'TestAdd',
            'email' => 'testaddcontroller@test.com',
            'password' => 'hello',
            'confirm_password' => 'hello',
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
        $output = $this->request('POST','registration/register',$postData);
        $this->assertContains('Thank you for your registration. Your entry is subject for approval. You can start you submission once approved.', $output);
    }
    
    public function test_delete(){
        // Add registration.
        $postData = [
            'last_name' => 'Del',
            'first_name' => 'Del',
            'email' => 'del@test.com',
            'password' => 'hello',
            'confirm_password' => 'hello',
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
        $output = $this->request('POST','registration/register',$postData);
        $this->assertContains('Thank you for your registration. Your entry is subject for approval. You can start you submission once approved.', $output);
        
        $page1 = $this->request('GET','registration/registrationList');
        $rowCount = substr_count($page1,'registration-row-item');
        // Delete company.
        $delPostData = [
            'delRegistrationIds' => '6',
        ];
        $delSuccess = $this->request(
            'POST',
            'registration/delete',
            $delPostData
        );
        $this->assertContains('Success', $delSuccess);
        $page2 = $this->request('GET','registration/registrationList');
        $newCount = substr_count($page2,'registration-row-item');
        $this->assertEquals($rowCount-1,$newCount);
    }
    
    public function test_search(){
        $output = $this->request('GET','registration/searchResult?condition_last_name=E&value_last_name=RegistrationVillarosa&display_last_name=on');
        $this->assertContains('RegistrationVillarosa', $output);
    }
}