<?php

class SkillSeeder extends Seeder {

    private $table = 'skill';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table skill;");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $data = [
            'id' => 1,
            'name' => 'Javascript',
            'is_deleted' => 0,
            'created_by' => 1,
            'created_time' => '2021-02-05 16:20:00',
        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 2,
            'name' => 'Scrum',
            'is_deleted' => 1,
            'deleted_by' => 1,
            'deleted_time' => '2021-02-05 18:21:00',
            'created_by' => 1,
            'created_time' => '2021-02-05 16:21:00',
        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 3,
            'name' => 'Go',
            'is_deleted' => 0,
            'created_time' => '2021-02-05 16:20:00',
        ];
        $this->db->insert($this->table, $data);
        
        $data = [
            'id' => 4,
            'name' => 'Git',
            'is_deleted' => 0,
            'created_time' => '2021-02-05 16:20:00',
        ];
        $this->db->insert($this->table, $data);
    }
}
