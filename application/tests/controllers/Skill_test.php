<?php

class Skill_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        // Reset user database.
        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('SkillSeeder');
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
    
    public function test_getSkillsByCategory(){
        $page = $this->request(
            'GET',
            'skill/getSkillsByCategory',
            [
                'skillCategoyId' => 1,
            ]
        );
        $this->assertContains('Javascript', $page);
        $this->assertNotContains('Scrum', $page);
        $this->assertContains('Go', $page);
        $this->assertNotContains('Indexing', $page);
    }
    
    public function test_skillList(){
        $page = $this->request(
            'GET',
            'skill/skillList',
            [
                'skillCategoyId' => 1,
            ]
        );
        $this->assertContains('Javascript', $page);
        $this->assertNotContains('Scrum', $page);
        $this->assertContains('Go', $page);
        $this->assertContains('Indexing', $page);
    }
    
    public function test_add(){
        $page = $this->request(
            'POST',
            'skill/add',
            [
                'skill_category_id' => 2,
            ]
        );
        $this->assertEquals($page,'Skill name is required');
        $page = $this->request(
            'POST',
            'skill/add',
            [
                'skill_name' => 'Balance Sheet',
            ]
        );
        $this->assertEquals($page,'Skill category is required');
        $page = $this->request(
            'POST',
            'skill/add',
            [
                'skill_name' => 'Balance Sheet',
                'skill_category_id' => 2,
            ]
        );
        $this->assertEquals($page,'Success');
        $page = $this->request(
            'POST',
            'skill/add',
            [
                'skill_name' => 'Balance Sheet',
                'skill_category_id' => 2,
            ]
        );
        $this->assertEquals($page,'Skill already exist');
    }
    
    public function test_update(){
        $page = $this->request(
            'POST',
            'skill/update',
            [
                'update_skill_name' => 'Balance Sheet',
                'update_cat_id' => 2,
            ]
        );
        $this->assertEquals($page,'Error occured');
        $page = $this->request(
            'POST',
            'skill/update',
            [
                'skill_id' => 6,
                'update_cat_id' => 2,
            ]
        );
        $this->assertEquals($page,'Skill name is required');
        $page = $this->request(
            'POST',
            'skill/update',
            [
                'skill_id' => 6,
                'update_skill_name' => 'Balance Sheet',
            ]
        );
        $this->assertEquals($page,'Skill category is required');
        $page = $this->request(
            'POST',
            'skill/update',
            [
                'skill_id' => 6,
                'update_skill_name' => 'Balance Sheet',
                'update_cat_id' => 2,
            ]
        );
        $this->assertEquals($page,'Skill already exist');
        $page = $this->request(
            'POST',
            'skill/update',
            [
                'skill_id' => 6,
                'update_skill_name' => 'Balance Sheet',
                'update_cat_id' => 3,
            ]
        );
        $this->assertEquals($page,'Success');
    }
    
    public function test_delete(){
        $page = $this->request(
            'POST',
            'skill/delete',
            [
                'delSkillIds' => 6,
            ]
        );
        $this->assertEquals($page,'Success');
    }
    
    public function test_addCategory(){
        $page = $this->request(
            'POST',
            'skill/addCategory'
        );
        $this->assertEquals($page,'Error occured');
        $page = $this->request(
            'POST',
            'skill/addCategory',
            [
                'category_name' => 'Accounting',
            ]
        );
        $this->assertEquals($page,'Category already exist');
        $page = $this->request(
            'POST',
            'skill/addCategory',
            [
                'category_name' => 'Hotel/Restaurant Management',
            ]
        );
        $this->assertEquals($page,'Success');
    }
}
