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

    public function test_getUserById(){
        $actual = $this->obj->getUserById(1);
        $expected = 'admin';
        $this->assertEquals($expected, $actual->username);
    }
    
    public function test_getUserByUsername(){
        $actual = $this->obj->getUserByUsername('admin');
        $expected = 1;
        $this->assertEquals($expected, $actual->id);        
    }
    
    public function test_blockUser(){
        $this->obj->blockUser(1);
        $user  = $this->obj->getUserById(1);
        $this->assertEquals(USER_STATUS_BLOCKED, $user->status);        
    }
    
    public function test_activateUser(){
        $this->obj->activateUser(1);
        $user  = $this->obj->getUserById(1);
        $this->assertEquals(USER_STATUS_ACTIVE, $user->status);        
    }
    
    public function test_addLoginFailed(){
        $this->obj->addLoginFailed(1);
        $user  = $this->obj->getUserById(1);
        $this->assertEquals(1, $user->failed_login);        
    }
    
    public function test_resetLoginFailed(){
        $this->obj->resetLoginFailed(1);
        $user  = $this->obj->getUserById(1);
        $this->assertEquals(0, $user->failed_login);       
    }
    
    public function test_addUser(){
        $user = (object)[
            'username' => 'user4',
            'password' => 'user4pw',
            'role' => USER_ROLE_ADMIN,
            'status' => USER_STATUS_ACTIVE,
            'failed_login' => 0,
            'email' => 'user4@test.com',
            'contact_number' => '999999',
            'name' => 'User 4',
            'address' => 'Here',
            'birthday' => '1999-03-05',
        ];
        $inserted_id = $this->obj->addUser($user);
        $newUser  = $this->obj->getUserById($inserted_id);
        $this->assertEquals($newUser->username, $user->username);       
    }
    
    public function test_updateUserDetails(){
        // Add user.
        $user = (object)[
            'username' => 'ashketchup',
            'password' => 'ashketchup',
            'role' => USER_ROLE_ADMIN,
            'status' => USER_STATUS_ACTIVE,
            'failed_login' => 0,
            'email' => 'ashketchup@test.com',
            'contact_number' => '999999',
            'name' => 'Ash Ketchup',
            'address' => 'Townsville',
            'birthday' => '1994-09-25',
        ];
        $inserted_id = $this->obj->addUser($user);
        
        // Update the added user.
        $newUserProps = (object)[
            'username' => 'ashketchup',
            'password' => 'ashketchup',
            'role' => USER_ROLE_RECRUITER,
            'status' => USER_STATUS_BLOCKED,
            'email' => 'updated@test.com',
            'contact_number' => '000',
            'name' => 'Updated User',
            'address' => 'I am a new creation',
            'birthday' => '2000-01-01',
        ];
        $this->obj->updateUserDetails($newUserProps,$inserted_id);
        $updatedUser  = $this->obj->getUserById($inserted_id);
        $this->assertEquals($updatedUser->role, $newUserProps->role);
        $this->assertEquals($updatedUser->status, $newUserProps->status);
        $this->assertEquals($updatedUser->email, $newUserProps->email);
        $this->assertEquals($updatedUser->contact_number, $newUserProps->contact_number);
        $this->assertEquals($updatedUser->name, $newUserProps->name);
        $this->assertEquals($updatedUser->address, $newUserProps->address);
        $this->assertEquals($updatedUser->birthday, $newUserProps->birthday);
    }
}
