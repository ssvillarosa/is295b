<?php

class UserSeeder extends Seeder {

	private $table = 'user';

	public function run()
	{
		$this->db->truncate($this->table);

		$data = [
			'id' => 1,
			'username' => 'admin',
			'password' => 'adminpw',
		];
		$this->db->insert($this->table, $data);
		
		$data = [
			'id' => 2,
			'username' => 'steven',
			'password' => 'stevenpw',
		];
		$this->db->insert($this->table, $data);
		
		$data = [
			'id' => 3,
			'username' => 'guest',
			'password' => 'guestpw',
		];
		$this->db->insert($this->table, $data);
	}

}
