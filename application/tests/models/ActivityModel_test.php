<?php

class ActivityModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('UserSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('ActivityModel');
    }

    public function test_saveUserActivity(){
        $success = $this->obj->saveUserActivity(1,'test');
        $this->assertTrue($success);
    }
}
