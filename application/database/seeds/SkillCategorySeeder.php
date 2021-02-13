<?php

class SkillCategorySeeder extends Seeder {

    private $skill_table = 'skill';
    private $category_table = 'skill_category';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table {$this->skill_table};");
        $this->db->query("TRUNCATE table {$this->category_table};");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $categories = [
            [
                'id' => 1,
                'name' => 'Uncategorized',
            ],
            [
                'id' => 2,
                'name' => 'Accounting',
            ],
            [
                'id' => 3,
                'name' => 'Finance',
            ],
            [
                'id' => 4,
                'name' => 'Others',
            ],
        ];
        foreach ($categories as $category) {
            $this->db->insert($this->category_table, $category);            
        }
        
        $skills = [
            [
                'id' => 1,
                'name' => 'Javascript',
                'category_id' => 1,
                'is_deleted' => 0,
                'created_by' => 1,
                'created_time' => '2021-02-05 16:20:00'
            ],
            [
                'id' => 2,
                'name' => 'Scrum',
                'category_id' => 1,
                'is_deleted' => 1,
                'deleted_by' => 1,
                'deleted_time' => '2021-02-05 18:21:00',
                'created_by' => 1,
                'created_time' => '2021-02-05 16:21:00'
            ],
            [
                'id' => 3,
                'name' => 'Go',
                'category_id' => 1,
                'is_deleted' => 0,
                'created_time' => '2021-02-05 16:20:00'
            ],
            [
                'id' => 4,
                'category_id' => 2,
                'name' => 'Indexing',
                'is_deleted' => 0,
                'created_time' => '2021-02-05 16:20:00'
            ],
        ];
        foreach ($skills as $skill) {
            $this->db->insert($this->skill_table, $skill);            
        }
    }
}
