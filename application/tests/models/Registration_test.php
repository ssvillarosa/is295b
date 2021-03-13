<?php

class RegistrationModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('RegistrationSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('RegistrationModel');
    }    

    public function test_getRegistrations(){
        $expected = [
            1 => 'RegistrationVillarosa',
            2 => 'Cant II Registration',
            3 => 'Registration',
        ];
        $registrations = $this->obj->getRegistrations();
        $this->assertNotEquals($registrations,ERROR_CODE);
        $this->assertNotEmpty($registrations);
        foreach ($registrations as $registration) {
                $this->assertEquals($expected[$registration->id], $registration->last_name);
        }
    }
    
    public function test_getRegistrationById(){
        $id = 1;
        $expected = [
            1 => 'RegistrationVillarosa',
            2 => 'Cant II',
            3 => 'San Jose',
        ];
        $registration = $this->obj->getRegistrationById($id);
        $this->assertNotEquals($registration,ERROR_CODE);
        $this->assertNotEmpty($registration);
        $this->assertEquals($expected[$id], $registration->last_name);
    }
    
    public function test_getRegistrationByEmail(){
        $email = "steven.registration@test.com";
        $registration = $this->obj->getRegistrationByEmail($email);
        $this->assertNotEquals($registration,ERROR_CODE);
        $this->assertNotEmpty($registration);
        $this->assertEquals("RegistrationVillarosa", $registration->last_name);
    }
    
    public function test_addRegistration(){
        $registration = (object)[
            'last_name' => 'New',
            'first_name' => 'Registration',
            'email' => 'new_registration@test.com',
            'password' => 'hello',
            'primary_phone' => '1111',
            'secondary_phone' => '2222',
            'work_phone' => '3333',
            'best_time_to_call' => '2PM',
            'address' => 'Goner',
            'can_relocate' => 1,
            'is_deleted' => 0,
        ];
        $inserted_id = $this->obj->addRegistration($registration);
        $newRegistration  = $this->obj->getRegistrationById($inserted_id);
        $this->assertNotEquals($newRegistration,ERROR_CODE);
        $this->assertNotNull($newRegistration);
        $this->assertEquals($newRegistration->last_name, $registration->last_name);       
    }
    
    public function test_updateRegistration(){
        $registration = (object)[
            'last_name' => 'Updated',
            'first_name' => 'Candidate',
            'email' => 'updated_registration@test.com',
            'password' => 'hello',
            'primary_phone' => '000',
            'secondary_phone' => '00',
            'work_phone' => '000',
            'best_time_to_call' => '6AM',
            'address' => 'Here',
            'can_relocate' => 0,
        ];
        $registration1  = $this->obj->getRegistrationById(2);
        $this->assertNotEquals($registration1->last_name,$registration->last_name);
        $result = $this->obj->updateRegistration($registration,2);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedRegistration1 = $this->obj->getRegistrationById(2);
        $this->assertEquals($updatedRegistration1->last_name,$registration->last_name); 
        $this->assertEquals($updatedRegistration1->first_name,$registration->first_name); 
        $this->assertEquals($updatedRegistration1->email,$registration->email); 
        $this->assertEquals($updatedRegistration1->primary_phone,$registration->primary_phone); 
        $this->assertEquals($updatedRegistration1->secondary_phone,$registration->secondary_phone); 
        $this->assertEquals($updatedRegistration1->work_phone,$registration->work_phone); 
        $this->assertEquals($updatedRegistration1->best_time_to_call,$registration->best_time_to_call); 
        $this->assertEquals($updatedRegistration1->address,$registration->address); 
        $this->assertEquals($updatedRegistration1->can_relocate,$registration->can_relocate);    
    }
    
    public function test_getRegistrationCount(){
        $registrationCount  = $this->obj->getRegistrationCount();
        $this->assertEquals($registrationCount, 4);    
    }
    
    public function test_deleteRegistration(){
        $registrationCount  = $this->obj->getRegistrationCount(); 
        $this->obj->deleteRegistration(5,1);
        $newCount  = $this->obj->getRegistrationCount();
        $this->assertEquals($newCount, $registrationCount-1);    
    }
    
    public function test_getRegistrationSkill(){
        $registrationSkills  = $this->obj->getRegistrationSkill(1); 
        $expected = [
            [
                'registration_id' => 1,
                'skill_id' => 1,
                'years_of_experience' => 8,
            ],
            [
                'registration_id' => 1,
                'skill_id' => 3,
                'years_of_experience' => 6,
            ],
            [
                'registration_id' => 1,
                'skill_id' => 4,
                'years_of_experience' => 5,
            ],
        ];
        $this->assertNotEquals($registrationSkills,ERROR_CODE);
        foreach ($registrationSkills as $key=>$registrationSkill) {
                $this->assertEquals($expected[$key]["skill_id"], $registrationSkill->skill_id);
                $this->assertEquals($expected[$key]["years_of_experience"], $registrationSkill->years_of_experience);
        }
    }
    
    public function test_searchRegistration(){
        $searchParam = [
            (object)[
                "field" => "last_name",
                "condition" => "E",
                "value" => "RegistrationVillarosa",
                "show" => 1,
            ]
        ];
        $registration  = $this->obj->searchRegistration($searchParam,["last_name"]);
        $this->assertEquals($registration[0]["last_name"], "RegistrationVillarosa");
    }
    
    public function test_searchRegistrationCount(){
        $searchParam = [
            (object)[
                "field" => "last_name",
                "condition" => "E",
                "value" => "RegistrationVillarosa",
                "show" => 1,
            ]
        ];
        $registration  = $this->obj->searchRegistrationCount($searchParam);
        $this->assertEquals(count($registration), 1);
    }
}
