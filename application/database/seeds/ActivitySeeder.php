<?php

class ActivitySeeder extends Seeder {

    private $activity_table = 'activity';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table {$this->activity_table};");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $activities = [
            [
                'id' => 1,
                'timestamp' => '2021-03-31 19:46:00',
                'pipeline_id' => 1,
                'updated_by' => 1,
                'activity_type' => 1,
                'activity' => 'Change assignment activity',
            ],[
                'id' => 2,
                'timestamp' => '2021-03-31 19:47:00',
                'pipeline_id' => 1,
                'updated_by' => 1,
                'activity_type' => 2,
                'activity' => 'Status update activity',
            ],[
                'id' => 3,
                'timestamp' => '2021-03-31 19:48:00',
                'pipeline_id' => 1,
                'updated_by' => 1,
                'activity_type' => 3,
                'activity' => 'Note activity',
            ],
        ];
        foreach ($activities as $activity) {
            $this->db->insert($this->activity_table, $activity);            
        }
    }
}
