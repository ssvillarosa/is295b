<?php

class UserLogModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('UserSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('UserLogModel');
    }

    public function test_saveUserUserLog(){
        $success = $this->obj->saveUserLog(1,'test');
        $this->assertTrue($success);
    }
    
    public function test_getUserActivities(){
        $activities = $this->obj->getUserLogs(1);
        $this->assertEquals($activities[0]->activity,'test');
    }
}
