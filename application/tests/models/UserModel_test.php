<?php

class UserModel_test extends UnitTestCase {
    private $_mock_values;
    private $_mock_db;
    
    public function setUp(){
        $this->obj = $this->newModel('UserModel');
        $this->_mock_values = [
            0 => (object) ['id' => '1', 'username' => 'admin', 'password' => 'adminpw'],
            1 => (object) ['id' => '2', 'username' => 'steven', 'password' => 'stevenpw'],
            2 => (object) ['id' => '3', 'username' => 'guest', 'password' => 'guestpw'],
        ];
        $db_result = $this->getMockBuilder('CI_DB_pdo_result')
            ->disableOriginalConstructor()
            ->getMock();
        $db_result->method('result')->willReturn($this->_mock_values);
        $this->_mock_db = $this->getMockBuilder('CI_DB_pdo_sqlite_driver')
            ->disableOriginalConstructor()
            ->getMock();
        $this->_mock_db->method('get')->willReturn($db_result);
    }

    public function test_getUsers(){
        // Replace property db with mock object
        $this->obj->db = $this->_mock_db;

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
