<?php

class User_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('UserSeeder');
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
    
    public function test_userList(){
        $output = $this->request('GET','user/userList');
        $this->assertContains('id="user-1"', $output);
        $this->assertContains('id="user-2"', $output);
        $this->assertContains('id="user-3"', $output);
    }
    
    public function test_view(){
        $output = $this->request('GET','user/view?id=1');
        $this->assertContains('<h5 class="mb-3">Username: admin</h5>', $output);
    }
}
