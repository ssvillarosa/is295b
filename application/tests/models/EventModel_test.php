<?php

class EventModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ActivitySeeder');
        $CI->seeder->call('EventSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('EventModel');
    }    

    public function test_getEvents(){
        $expected = [
            1 => 'Event 1',
            2 => 'Event 2',
            3 => 'Event 3',
        ];
        $events = $this->obj->getEvents();
        $this->assertNotEquals($events,ERROR_CODE);
        $this->assertNotEmpty($events);
        foreach ($events as $event) {
            $this->assertEquals($expected[$event->id], $event->title);
        }
    }
    
    public function test_getEventById(){
        $id = 1;
        $expected = [
            1 => 'Event 1',
            2 => 'Event 2',
            3 => 'Event 3',
        ];
        $event = $this->obj->getEventById($id);
        $this->assertNotEquals($event,ERROR_CODE);
        $this->assertNotEmpty($event);
        $this->assertEquals($expected[$id], $event->title);
    }
    
    public function test_addEvent(){
        $event = (object)[
            'title' => 'Event 4',
            'event_time' => '2021-04-06 21:29:00',
            'description' => 'Event 4 description',
            'is_public' => 0,
            'activity_id' => 3,
            'is_deleted' => 0,
        ];
        $inserted_id = $this->obj->addEvent($event);
        $newEvent  = $this->obj->getEventById($inserted_id);
        $this->assertNotEquals($newEvent,ERROR_CODE);
        $this->assertNotNull($newEvent);
        $this->assertEquals($newEvent->title, $event->title);       
    }
    
    public function test_updateEvent(){
        $event = (object)[
            'title' => 'Event 4 Updated',
            'event_time' => '2021-04-07 21:29:00',
            'description' => 'Event 4 description Updated',
            'is_public' => 1,
        ];
        $event1  = $this->obj->getEventById(4);
        $this->assertNotEquals($event1->title,$event->title);
        $result = $this->obj->updateEvent($event,4);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedEvent1 = $this->obj->getEventById(4);
        $this->assertEquals($updatedEvent1->title,$event->title); 
        $this->assertEquals($updatedEvent1->event_time,$event->event_time); 
        $this->assertEquals($updatedEvent1->description,$event->description); 
        $this->assertEquals($updatedEvent1->is_public,$event->is_public);
    }
    
    public function test_getEventCount(){
        $eventCount  = $this->obj->getEventCount();
        $this->assertEquals($eventCount, 4);    
    }
    
    public function test_searchEvent(){
        $searchParam = [
            (object)[
                "field" => "title",
                "condition" => "E",
                "value" => "Event 1",
                "show" => 1,
            ]
        ];
        $event  = $this->obj->searchEvent($searchParam,["title"]);
        $this->assertEquals($event[0]["title"], "Event 1");
    }
    
    public function test_searchEventCount(){
        $searchParam = [
            (object)[
                "field" => "title",
                "condition" => "E",
                "value" => "Event 1",
                "show" => 1,
            ]
        ];
        $event  = $this->obj->searchEventCount($searchParam);
        $this->assertEquals($event, 1);
    }
}
