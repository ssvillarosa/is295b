<?php

class ApplicantSeeder extends Seeder {

    private $applicant_table = 'applicant';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table {$this->applicant_table};");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $applicants = [
            [
                'id' => 1,
                'last_name' => 'Villarosa',
                'first_name' => 'Steven',
                'email' => 'steven@test.com',
                'primary_phone' => '1111',
                'secondary_phone' => '2222',
                'work_phone' => '3333',
                'best_time_to_call' => '2PM',
                'address' => 'Cavite',
                'source' => 'LinkedIn',
                'current_employer' => 'Cnx',
                'can_relocate' => 1,
                'current_pay' => 10000,
                'desired_pay' => 15000,
                'created_time' => '2021-02-05 16:22:00',
                'created_by' => 1,
                'is_deleted' => 0,
            ],[
                'id' => 2,
                'last_name' => 'Cant II',
                'first_name' => 'Appli',
                'email' => 'applicant@test.com',
                'primary_phone' => '9999',
                'secondary_phone' => '8888',
                'work_phone' => '7777',
                'best_time_to_call' => '3PM',
                'address' => 'Batangas',
                'source' => 'Jobstreet',
                'current_employer' => 'Company 1',
                'can_relocate' => 0,
                'current_pay' => 15000,
                'desired_pay' => 20000,
                'created_time' => '2021-02-05 16:22:00',
                'created_by' => 1,
                'is_deleted' => 0,
            ],[
                'id' => 3,
                'last_name' => 'San Jose',
                'first_name' => 'Theresa',
                'email' => 'tes_sanjose@test.com',
                'primary_phone' => '0000',
                'secondary_phone' => '0000',
                'work_phone' => '0000',
                'best_time_to_call' => '12PM',
                'address' => 'Laguna',
                'source' => 'Job Fair',
                'current_employer' => 'Amdocs',
                'can_relocate' => 1,
                'current_pay' => 25000,
                'desired_pay' => 30000,
                'created_time' => '2021-02-05 16:22:00',
                'created_by' => 1,
                'is_deleted' => 0,
            ],[
                'id' => 4,
                'last_name' => 'Deleted',
                'first_name' => 'Applicant',
                'email' => 'deleted_applicant@test.com',
                'primary_phone' => '1111',
                'secondary_phone' => '2222',
                'work_phone' => '3333',
                'best_time_to_call' => '2PM',
                'address' => 'Goner',
                'can_relocate' => 1,
                'created_time' => '2021-02-05 16:22:00',
                'created_by' => 1,
                'is_deleted' => 1,
            ]
        ];
        foreach ($applicants as $applicant) {
            $this->db->insert($this->applicant_table, $applicant);            
        }
        
    }
}
