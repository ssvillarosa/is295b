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
    }
}
