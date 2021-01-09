<?php

class UserModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('UserSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('UserModel');
    }

    public function test_getUsers(){
        $expected = [
            1 => 'admin',
            2 => 'steven',
            3 => 'guest',
        ];
        $users = $this->obj->getUsers();
        foreach ($users as $user) {
                $this->assertEquals($expected[$user->id], $user->username);
        }
    }

    public function test_getUser(){
        $actual = $this->obj->getUser(1);
        $expected = 'admin';
        $this->assertEquals($expected, $actual->username);
    }
    
    public function test_login(){
        $actual = $this->obj->login('admin','adminpw');
        $expected = 1;
        $this->assertEquals($expected, $actual->id);        
    }
}
