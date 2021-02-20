<?php

class CompanySeeder extends Seeder {

    private $table = 'company';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table company;");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $data = [
            'id' => 1,
            'name' => 'ABC Corp',
            'contact_person' => 'Steven Suanuqe',
            'primary_phone' => '9928283',
            'secondary_phone' => '',
            'address' => 'Alabang Muntinlupa',
            'website' => 'www.abc.com',
            'industry' => 'Hospitality',
            'created_time' => '2021-02-05 16:21:00',
            'created_by' => '1',
            'is_deleted' => '0',
            'deleted_time' => null,
            'deleted_by' => null,
        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 2,
            'name' => 'ADB Inc.',
            'contact_person' => 'Billy Joe',
            'primary_phone' => '464584',
            'secondary_phone' => '',
            'address' => 'Makati',
            'website' => 'www.adb.com',
            'industry' => 'IT',
            'created_time' => '2021-02-05 16:22:00',
            'created_by' => '1',
            'is_deleted' => '0',
            'deleted_time' => null,
            'deleted_by' => null,
        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 3,
            'name' => 'New Era Comp',
            'contact_person' => 'Newton',
            'primary_phone' => '90384',
            'secondary_phone' => '',
            'address' => 'New York',
            'website' => 'www.neweracomp.com',
            'industry' => 'Recruitment',
            'created_time' => '2021-02-05 16:23:00',
            'created_by' => '1',
            'is_deleted' => '0',
            'deleted_time' => null,
            'deleted_by' => null,
        ];
        $this->db->insert($this->table, $data);
        
        $data = [
            'id' => 4,
            'name' => 'Del Me',
            'contact_person' => 'None',
            'primary_phone' => '',
            'secondary_phone' => '',
            'address' => 'Not existing',
            'website' => 'www.missing.com',
            'industry' => 'Nowhere',
            'created_time' => '2021-02-05 16:24:00',
            'created_by' => '1',
            'is_deleted' => '1',
            'deleted_time' => '2021-02-05 16:25:00',
            'deleted_by' => '1',
        ];
        $this->db->insert($this->table, $data);
    }
}
