<?php

class UserSeeder extends Seeder {

    private $table = 'user';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table user_log;");
        $this->db->query("TRUNCATE table user;");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $data = [
            'id' => 1,
            'username' => 'admin',
            'password' => password_hash('adminpw', PASSWORD_DEFAULT),
            'role' => USER_ROLE_ADMIN,
            'status' => USER_STATUS_ACTIVE,
            'failed_login' => 0,
            'email' => 'admin@test.com',
            'contact_number' => '999999',
            'name' => 'Super Admin',
            'address' => 'CPU',
            'birthday' => '1990-01-01',

        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 2,
            'username' => 'steven',
            'password' => hashThis('stevenpw'),
            'role' => USER_ROLE_RECRUITER,
            'status' => USER_STATUS_ACTIVE,
            'failed_login' => 0,
            'email' => 'steven@test.com',
            'contact_number' => '0977',
            'name' => 'Steven Villarosa',
            'address' => 'Muntinlupa',
            'birthday' => '1991-05-18',
        ];
        $this->db->insert($this->table, $data);

        $data = [
            'id' => 3,
            'username' => 'guest',
            'password' => hashThis('guestpw'),
            'role' => USER_ROLE_RECRUITER,
            'status' => USER_STATUS_ACTIVE,
            'failed_login' => 0,
            'email' => 'guest@test.com',
            'contact_number' => '1234',
            'name' => 'Your guest',
            'address' => 'NCR',
            'birthday' => '1992-10-03',
        ];
        $this->db->insert($this->table, $data);
        
        $data = [
            'id' => 4,
            'username' => 'dummy',
            'password' => hashThis('dummypw'),
            'role' => USER_ROLE_RECRUITER,
            'status' => USER_STATUS_DELETED,
            'failed_login' => 0,
            'email' => 'dummy@test.com',
            'contact_number' => '321',
            'name' => 'Dummy user',
            'address' => 'Nowhere',
            'birthday' => '1993-07-08',
        ];
        $this->db->insert($this->table, $data);
    }
}
