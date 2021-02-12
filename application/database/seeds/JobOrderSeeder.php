<?php

class JobOrderSeeder extends Seeder {

    private $job_order_table = 'job_order';
    private $job_order_skill_table = 'job_order_skill';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table {$this->job_order_table};");
        $this->db->query("TRUNCATE table {$this->job_order_skill_table};");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $job_orders = [
            [
                'id' => 1,
                'title' => 'Software Developer',
                'company_id' => 1,
                'job_function' => 'Lorem Ipsum',
                'requirement' => 'Lorem Ipsum',
                'min_salary' => 90000,
                'max_salary' => 150000,
                'location' => 'BGC',
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:21:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 5,
                'priority_level' => 1,
            ],[
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
            ],[
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
            ],[
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
            ]
        ];
        foreach ($job_orders as $job_order) {
            $this->db->insert($this->job_order_table, $job_order);            
        }
        
        $job_order_skills= [
            [
                'id' => 1,
                'job_order_id' => 1,
                'skill_id' => 1,
                'years_of_experience' => 2,
            ],
            [
                'id' => 2,
                'job_order_id' => 1,
                'skill_id' => 2,
                'years_of_experience' => 2,
            ],
            [
                'id' => 3,
                'job_order_id' => 1,
                'skill_id' => 3,
                'years_of_experience' => 2,
            ],
            [
                'id' => 4,
                'job_order_id' => 1,
                'skill_id' => 4,
                'years_of_experience' => 2,
            ],
        ];
        foreach ($job_order_skills as $job_order_skill) {
            $this->db->insert($this->job_order_skill_table, $job_order_skill);            
        }
    }
}
