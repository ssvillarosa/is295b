<?php

class JobOrderSeeder extends Seeder {

    private $table = 'job_order';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table job_order;");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $data = [
            'id' => 1,
            'title' => 'Software Developer',
            'company_id' => 1,
            'job_function' => 'Lorem Ipsum',
            'requirement' => 'Lorem Ipsum',
            'min_salary' => 90000,
            'max_salary' => 150000,
            'employment_type' => 1,
            'status' => 1,
            'created_time' => '2021-02-05 16:21:00',
            'created_by' => 1,
            'is_deleted' => 0,
            'slots_available' => 5,
            'priority_level' => 1,
        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 2,
            'title' => 'Business Analyst',
            'company_id' => 1,
            'job_function' => 'Lorem Ipsum',
            'requirement' => 'Lorem Ipsum',
            'min_salary' => 50000,
            'max_salary' => 90000,
            'employment_type' => 1,
            'status' => 1,
            'created_time' => '2021-02-05 16:22:00',
            'created_by' => 1,
            'is_deleted' => 0,
            'slots_available' => 2,
            'priority_level' => 2,
        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 3,
            'title' => 'Quality Assurance',
            'company_id' => 1,
            'job_function' => 'Lorem Ipsum',
            'requirement' => 'Lorem Ipsum',
            'min_salary' => 30000,
            'max_salary' => 70000,
            'employment_type' => 1,
            'status' => 1,
            'created_time' => '2021-02-05 16:24:00',
            'created_by' => 1,
            'is_deleted' => 0,
            'slots_available' => 1,
            'priority_level' => 3,
        ];
        $this->db->insert($this->table, $data);
        
        $data = [
            'id' => 4,
            'title' => 'Compliance Officer',
            'company_id' => 2,
            'job_function' => 'Lorem Ipsum',
            'requirement' => 'Lorem Ipsum',
            'min_salary' => 50000,
            'max_salary' => 90000,
            'employment_type' => 2,
            'status' => 1,
            'created_time' => '2021-02-05 16:25:00',
            'created_by' => 1,
            'is_deleted' => 1,
            'deleted_time' => '2021-02-05 17:25:00',
            'slots_available' => 1,
            'priority_level' => 4,
        ];
        $this->db->insert($this->table, $data);
    }
}
