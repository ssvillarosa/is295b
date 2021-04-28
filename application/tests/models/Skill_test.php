<?php

class SkillModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('SkillSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('SkillModel');
    }    

    public function test_getSkills(){
        $expected = [
            1 => 'Javascript',
            3 => 'Go',
            4 => 'Indexing',
        ];
        $skills = $this->obj->getSkills();
        $this->assertNotEquals($skills,ERROR_CODE);
        $this->assertNotEmpty($skills);
        foreach ($skills as $skill) {
                $this->assertEquals($expected[$skill->id], $skill->name);
        }
    }
    
    public function test_getSkillById(){
        $id = 3;
        $expected = [
            1 => 'Javascript',
            3 => 'Go',
            4 => 'Git',
        ];
        $company = $this->obj->getSkillById($id);
        $this->assertNotEquals($company,ERROR_CODE);
        $this->assertNotEmpty($company);
        $this->assertEquals($expected[$id], $company->name);
    }
    
    public function test_addSkill(){
        $skill = (object)[
            'name' => 'CSS',
            'category_id' => 1,
        ];
        $inserted_id = $this->obj->addSkill($skill);
        $newSkill  = $this->obj->getSkillById($inserted_id);
        $this->assertNotEquals($newSkill,ERROR_CODE);
        $this->assertEquals($newSkill->name, $skill->name);       
    }
    
    public function test_updateSkill(){
        $id = 5;
        $skill = (object)[
            'name' => 'HTML',
        ];
        $skill1  = $this->obj->getSkillById($id);
        $this->assertNotEquals($skill1->name,$skill->name);
        $result = $this->obj->updateSkill($skill,$id);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedSkill1 = $this->obj->getSkillById($id);
        $this->assertEquals($updatedSkill1->name,$skill->name);    
    }
    
    public function test_deleteSkill(){
        $skillCount  = $this->obj->getSkillCount(); 
        $this->obj->deleteSkill(5,1);
        $newCount  = $this->obj->getSkillCount();
        $this->assertEquals($newCount, $skillCount-1);    
    }
    
    public function test_skillExist(){
        // Same skill name, same category.
        $skill1Exists = $this->obj->skillExist('Javascript',1); 
        $this->assertTrue($skill1Exists);
        // Same skill name, different category.
        $skill2Exists = $this->obj->skillExist('Javascript',2); 
        $this->assertNotTrue($skill2Exists);
    }
}
