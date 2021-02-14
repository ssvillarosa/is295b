<?php

class JobOrder_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('JobOrderSeeder');
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
    
    public function test_jobOrderList(){
        $output = $this->request('GET','job_order/jobOrderList');
        $this->assertContains('id="job_order-1"', $output);
        $this->assertContains('id="job_order-2"', $output);
        $this->assertContains('id="job_order-3"', $output);
    }
    
    public function test_view(){
        $output = $this->request('GET','job_order/view?id=1');
        $this->assertContains('value="Software Developer"', $output);
        $this->assertContains('id="skill-1"', $output);
        $this->assertContains('id="skill-3"', $output);
        $this->assertContains('id="skill-4"', $output);
    }
    
    public function test_update(){
        $postData = [
            'jobOrderId' => '2',
            'title' => 'Software',
            'company_id' => '3',
            'min_salary' => '11111',
            'max_salary' => '1111110000',
            'employment_type' => '2',
            'status' => '2',
            'job_function' => '11111',
            'requirement' => '11111111111',
            'skillIds' => '1,4',
            'skillNames' => 'Javascript,Indexing',
            'yearsOfExperiences' => '8,1',
            'location' => '111111',
            'slots_available' => '10',
            'priority_level' => '10',
        ];
        $this->request('POST','job_order/update',$postData);
        $output = $this->request('GET','job_order/view?id=2');
        $this->assertContains('value="Software"', $output);
        $this->assertContains('id="skill-1"', $output);
        $this->assertContains('id="skill-4"', $output);
        $this->assertNotContains('id="skill-3"', $output);
    }
}
