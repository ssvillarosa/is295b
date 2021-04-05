<?php

class EventSeeder extends Seeder {

    private $event_table = 'event';

    public function run()
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table {$this->event_table};");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $events = [
            [
                'id' => 1,
                'title' => 'Event 1',
                'event_time' => '2021-04-05 21:27:00',
                'description' => 'Event 1 description',
                'is_public' => 0,
                'activity_id' => 1,
                'is_deleted' => 0,
            ],[
                'id' => 2,
                'title' => 'Event 2',
                'event_time' => '2021-04-05 21:28:00',
                'description' => 'Event 2 description',
                'is_public' => 1,
                'activity_id' => 2,
                'is_deleted' => 0,
            ],[
                'id' => 3,
                'title' => 'Event 3',
                'event_time' => '2021-04-05 21:29:00',
                'description' => 'Event 3 description',
                'is_public' => 0,
                'activity_id' => 3,
                'is_deleted' => 0,
            ],
        ];
        foreach ($events as $event) {
            $this->db->insert($this->event_table, $event);            
        }
    }
}
