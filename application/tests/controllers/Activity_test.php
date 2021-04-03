<?php

class Activity_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ActivitySeeder');
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
    
    public function test_activityListByPipeline(){
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        
        $this->assertContains('Job Order Title: Software Developer', $page);
        $this->assertContains('Candidate Full Name: Steven Villarosa', $page);
        $this->assertContains('Assigned To: Super Admin', $page);
        $this->assertContains('Change assignment activity', $page);
        $this->assertContains('Status update activity', $page);
        $this->assertContains('Note activity', $page);
    }
    
    public function test_add_changeAssignment(){
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_assigned_to' => 'on',
                'user_select' => 3,
            ]
        );
        $this->assertContains('Success', $result); 
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('Assigned To: Your guest', $page);        
    }
    
    public function test_add_updateStatus(){
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_status' => 'on',
                'status' => 3,
            ]
        );
        $this->assertContains('Success', $result); 
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('Status: For screening', $page);        
    }
}
