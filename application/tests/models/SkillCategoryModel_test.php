<?php

class SkillCategoryModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('SkillCategorySeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('SkillCategoryModel');
    }    

    public function test_getSkillCategories(){
        $expected = [
            1 => 'Uncategorized',
            2 => 'Accounting',
            3 => 'Finance',
            4 => 'Others',
        ];
        $skillCategories = $this->obj->getSkillCategories();
        $this->assertNotEquals($skillCategories,ERROR_CODE);
        $this->assertNotEmpty($skillCategories);
        foreach ($skillCategories as $skillCategories) {
                $this->assertEquals($expected[$skillCategories->id], $skillCategories->name);
        }
    }
    
    public function test_getSkillCategoryById(){
        $id = 3;
        $expected = [
            1 => 'Uncategorized',
            2 => 'Accounting',
            3 => 'Finance',
        ];
        $category = $this->obj->getSkillCategoryById($id);
        $this->assertNotEquals($category,ERROR_CODE);
        $this->assertNotEmpty($category);
        $this->assertEquals($expected[$id], $category->name);
    }
    
    public function test_addSkillCategory(){
        $skillCategory = (object)[
            'name' => 'HR',
        ];
        $inserted_id = $this->obj->addSkillCategory($skillCategory);
        $newSkill  = $this->obj->getSkillCategoryById($inserted_id);
        $this->assertNotEquals($newSkill,ERROR_CODE);
        $this->assertEquals($newSkill->name, $skillCategory->name);       
    }
    
    public function test_updateSkillCategory(){
        $id = 5;
        $skillCategory = (object)[
            'name' => 'Human Resource',
        ];
        $skillCategory1  = $this->obj->getSkillCategoryById($id);
        $this->assertNotEquals($skillCategory1->name,$skillCategory->name);
        $result = $this->obj->updateSkillCategory($skillCategory,$id);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedSkillCategory1 = $this->obj->getSkillCategoryById($id);
        $this->assertEquals($updatedSkillCategory1->name,$skillCategory->name);    
    }
    
    public function test_deleteSkillCategory(){
        $skillCategoryCount  = $this->obj->getSkillCategoryCount(); 
        $this->obj->deleteSkillCategory(5,1);
        $newCount  = $this->obj->getSkillCategoryCount();
        $this->assertEquals($newCount, $skillCategoryCount-1);    
    }
}
