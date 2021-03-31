<?php

class ActivityModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('ActivitySeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('ActivityModel');
    }    

    public function test_getActivities(){
        $expected = [
            1 => 'Change assignment activity',
            2 => 'Status update activity',
            3 => 'Note activity',
        ];
        $activities = $this->obj->getActivities();
        $this->assertNotEquals($activities,ERROR_CODE);
        $this->assertNotEmpty($activities);
        foreach ($activities as $activity) {
            $this->assertEquals($expected[$activity->id], $activity->activity);
        }
    }
    
    public function test_getActivityById(){
        $id = 1;
        $expected = [
            1 => 'Change assignment activity',
            2 => 'Status update activity',
            3 => 'Note activity',
        ];
        $activity = $this->obj->getActivityById($id);
        $this->assertNotEquals($activity,ERROR_CODE);
        $this->assertNotEmpty($activity);
        $this->assertEquals($expected[$id], $activity->activity);
    }
    
    public function test_addActivity(){
        $activity = (object)[
            'timestamp' => '2021-03-31 19:49:00',
            'pipeline_id' => '2',
            'updated_by' => '1',
            'activity_type' => '3',
            'activity' => 'Email activity',
        ];
        $inserted_id = $this->obj->addActivity($activity);
        $newActivity  = $this->obj->getActivityById($inserted_id);
        $this->assertNotEquals($newActivity,ERROR_CODE);
        $this->assertNotNull($newActivity);
        $this->assertEquals($newActivity->activity, $activity->activity);       
    }
    
    public function test_updateActivity(){
        $activity = (object)[
            'timestamp' => '2021-03-31 19:50:00',
            'pipeline_id' => '2',
            'updated_by' => '1',
            'activity_type' => '3',
            'activity' => 'Note activity',
        ];
        $activity1  = $this->obj->getActivityById(4);
        $this->assertNotEquals($activity1->activity,$activity->activity);
        $result = $this->obj->updateActivity($activity,4);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedActivity1 = $this->obj->getActivityById(4);
        $this->assertEquals($updatedActivity1->timestamp,$activity->timestamp); 
        $this->assertEquals($updatedActivity1->pipeline_id,$activity->pipeline_id); 
        $this->assertEquals($updatedActivity1->updated_by,$activity->updated_by); 
        $this->assertEquals($updatedActivity1->activity_type,$activity->activity_type); 
        $this->assertEquals($updatedActivity1->activity,$activity->activity); 
    }
    
    public function test_getActivityCount(){
        $activityCount  = $this->obj->getActivityCount();
        $this->assertEquals($activityCount, 4);    
    }
    
    public function test_searchActivity(){
        $searchParam = [
            (object)[
                "field" => "activity",
                "condition" => "E",
                "value" => "Change assignment activity",
                "show" => 1,
            ]
        ];
        $activity  = $this->obj->searchActivity($searchParam,["activity"]);
        $this->assertEquals($activity[0]["activity"], "Change assignment activity");
    }
    
    public function test_searchActivityCount(){
        $searchParam = [
            (object)[
                "field" => "activity",
                "condition" => "E",
                "value" => "Change assignment activity",
                "show" => 1,
            ]
        ];
        $activity  = $this->obj->searchActivityCount($searchParam);
        $this->assertEquals($activity, 1);
    }
}
