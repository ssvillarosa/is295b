<?php

class ApplicantModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ApplicantSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('ApplicantModel');
    }    

    public function test_getApplicants(){
        $expected = [
            1 => 'Villarosa',
            2 => 'Cant II',
            3 => 'San Jose',
        ];
        $applicants = $this->obj->getApplicants();
        $this->assertNotEquals($applicants,ERROR_CODE);
        $this->assertNotEmpty($applicants);
        foreach ($applicants as $applicant) {
                $this->assertEquals($expected[$applicant->id], $applicant->last_name);
        }
    }
    
    public function test_getApplicantById(){
        $id = 1;
        $expected = [
            1 => 'Villarosa',
            2 => 'Cant II',
            3 => 'San Jose',
        ];
        $applicant = $this->obj->getApplicantById($id);
        $this->assertNotEquals($applicant,ERROR_CODE);
        $this->assertNotEmpty($applicant);
        $this->assertEquals($expected[$id], $applicant->last_name);
    }
    
    public function test_addApplicant(){
        $applicant = (object)[
            'last_name' => 'New',
            'first_name' => 'Applicant',
            'email' => 'new_applicant@test.com',
            'primary_phone' => '1111',
            'secondary_phone' => '2222',
            'work_phone' => '3333',
            'best_time_to_call' => '2PM',
            'address' => 'Goner',
            'can_relocate' => 1,
            'created_by' => 1,
            'is_deleted' => 0,
        ];
        $inserted_id = $this->obj->addApplicant($applicant);
        $newApplicant  = $this->obj->getApplicantById($inserted_id);
        $this->assertNotEquals($newApplicant,ERROR_CODE);
        $this->assertNotNull($newApplicant);
        $this->assertEquals($newApplicant->last_name, $applicant->last_name);       
    }
    
    public function test_updateApplicant(){
        $applicant = (object)[
            'last_name' => 'Updated',
            'first_name' => 'Candidate',
            'email' => 'updated_applicant@test.com',
            'primary_phone' => '000',
            'secondary_phone' => '00',
            'work_phone' => '000',
            'best_time_to_call' => '6AM',
            'address' => 'Here',
            'can_relocate' => 0,
        ];
        $applicant1  = $this->obj->getApplicantById(2);
        $this->assertNotEquals($applicant1->last_name,$applicant->last_name);
        $result = $this->obj->updateApplicant($applicant,2);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedApplicant1 = $this->obj->getApplicantById(2);
        $this->assertEquals($updatedApplicant1->last_name,$applicant->last_name); 
        $this->assertEquals($updatedApplicant1->first_name,$applicant->first_name); 
        $this->assertEquals($updatedApplicant1->email,$applicant->email); 
        $this->assertEquals($updatedApplicant1->primary_phone,$applicant->primary_phone); 
        $this->assertEquals($updatedApplicant1->secondary_phone,$applicant->secondary_phone); 
        $this->assertEquals($updatedApplicant1->work_phone,$applicant->work_phone); 
        $this->assertEquals($updatedApplicant1->best_time_to_call,$applicant->best_time_to_call); 
        $this->assertEquals($updatedApplicant1->address,$applicant->address); 
        $this->assertEquals($updatedApplicant1->can_relocate,$applicant->can_relocate);    
    }
    
    public function test_getApplicantCount(){
        $applicantCount  = $this->obj->getApplicantCount();
        $this->assertEquals($applicantCount, 4);    
    }
    
    public function test_deleteApplicant(){
        $applicantCount  = $this->obj->getApplicantCount(); 
        $this->obj->deleteApplicant(5,1);
        $newCount  = $this->obj->getApplicantCount();
        $this->assertEquals($newCount, $applicantCount-1);    
    }
    
    public function test_getApplicantSkill(){
        $applicantSkills  = $this->obj->getApplicantSkill(1); 
        $expected = [
            [
                'applicant_id' => 1,
                'skill_id' => 1,
                'years_of_experience' => 8,
            ],
            [
                'applicant_id' => 1,
                'skill_id' => 3,
                'years_of_experience' => 6,
            ],
            [
                'applicant_id' => 1,
                'skill_id' => 4,
                'years_of_experience' => 5,
            ],
        ];
        $this->assertNotEquals($applicantSkills,ERROR_CODE);
        foreach ($applicantSkills as $key=>$applicantSkill) {
                $this->assertEquals($expected[$key]["skill_id"], $applicantSkill->skill_id);
                $this->assertEquals($expected[$key]["years_of_experience"], $applicantSkill->years_of_experience);
        }
    }
}
