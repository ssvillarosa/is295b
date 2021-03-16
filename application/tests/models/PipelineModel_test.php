<?php

class PipelineModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('PipelineSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('PipelineModel');
    }    

    public function test_getPipelines(){
        $expected = [
            (object)[
                'id' => '1',
                'job_order_id' => '1',
                'applicant_id' => '1',
                'status' => strval(SOURCED),
                'assigned_to' => '1',
                'rating' => '5',
                'created_by' => '1',
                'created_time' => '2021-03-16 11:52:00',
                'is_deleted' => '0',
                'deleted_by' => null,
                'deleted_time' => null,
            ],(object)[
                'id' => '2',
                'job_order_id' => '1',
                'applicant_id' => '2',
                'status' => strval(FOR_SCREENING),
                'assigned_to' => '1',
                'rating' => '4',
                'created_by' => '1',
                'created_time' => '2021-03-16 11:53:00',
                'is_deleted' => '0',
                'deleted_by' => null,
                'deleted_time' => null,
            ],(object)[
                'id' => '3',
                'job_order_id' => '1',
                'applicant_id' => '3',
                'status' => strval(AWAITING_CV),
                'assigned_to' => '1',
                'rating' => '3',
                'created_by' => '1',
                'created_time' => '2021-03-16 11:54:00',
                'is_deleted' => '0',
                'deleted_by' => null,
                'deleted_time' => null,
            ]
        ];
        $pipelines = $this->obj->getPipelines();
        $this->assertNotEquals($pipelines,ERROR_CODE);
        $this->assertNotEmpty($pipelines);
        $this->assertEquals($expected, $pipelines);
    }
    
    public function test_getPipelineById(){
        $id = 1;
        $expected = (object)[
            'id' => '1',
            'job_order_id' => '1',
            'applicant_id' => '1',
            'status' => strval(SOURCED),
            'assigned_to' => '1',
            'rating' => '5',
            'created_by' => '1',
            'created_time' => '2021-03-16 11:52:00',
            'is_deleted' => '0',
            'deleted_by' => null,
            'deleted_time' => null,
        ];
        $pipeline = $this->obj->getPipelineById($id);
        $this->assertNotEquals($pipeline,ERROR_CODE);
        $this->assertNotEmpty($pipeline);
        $this->assertEquals($expected, $pipeline);
    }
    
    public function test_addPipeline(){
        $pipeline = (object)[
            'job_order_id' => 2,
            'applicant_id' => 2,
            'status' => SOURCED,
            'assigned_to' => 1,
            'rating' => 5,
            'created_by' => 1,
            'is_deleted' => 0,
        ];
        $inserted_id = $this->obj->addPipeline($pipeline);
        $newPipeline  = $this->obj->getPipelineById($inserted_id);
        $this->assertNotEquals($newPipeline,ERROR_CODE);
        $this->assertNotNull($newPipeline);
        $this->assertEquals($newPipeline->job_order_id, $pipeline->job_order_id);
        $this->assertEquals($newPipeline->applicant_id, $pipeline->applicant_id);
        $this->assertEquals($newPipeline->status, $pipeline->status);
        $this->assertEquals($newPipeline->assigned_to, $pipeline->assigned_to);
        $this->assertEquals($newPipeline->rating, $pipeline->rating);
        $this->assertEquals($newPipeline->created_by, $pipeline->created_by);
    }
    
    public function test_updatePipeline(){
        $pipeline = (object)[
            'job_order_id' => 2,
            'applicant_id' => 1,
            'status' => SOURCED,
            'assigned_to' => 1,
            'rating' => 5,
        ];
        $pipeline1  = $this->obj->getPipelineById(2);
        $this->assertNotEquals($pipeline1->job_order_id,$pipeline->job_order_id);
        $result = $this->obj->updatePipeline($pipeline,2);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedPipeline1 = $this->obj->getPipelineById(2);
        $this->assertEquals($updatedPipeline1->job_order_id,$pipeline->job_order_id); 
        $this->assertEquals($updatedPipeline1->applicant_id,$pipeline->applicant_id); 
        $this->assertEquals($updatedPipeline1->status,$pipeline->status); 
        $this->assertEquals($updatedPipeline1->assigned_to,$pipeline->assigned_to); 
        $this->assertEquals($updatedPipeline1->rating,$pipeline->rating);   
    }
    
    public function test_getPipelineCount(){
        $pipelineCount  = $this->obj->getPipelineCount();
        $this->assertEquals($pipelineCount, 4);    
    }
    
    public function test_deletePipeline(){
        $pipelineCount  = $this->obj->getPipelineCount(); 
        $this->obj->deletePipeline(5,1);
        $newCount  = $this->obj->getPipelineCount();
        $this->assertEquals($newCount, $pipelineCount-1);    
    }
    
    public function test_searchPipeline(){
        $searchParam = [
            (object)[
                "field" => "title",
                "condition" => "E",
                "value" => "Software Developer",
                "show" => 1,
            ]
        ];
        $pipeline  = $this->obj->searchPipeline($searchParam,["title"]);
        $this->assertEquals($pipeline[0]["title"], "Software Developer");
    }
    
    public function test_searchPipelineCount(){
        $searchParam = [
            (object)[
                "field" => "title",
                "condition" => "E",
                "value" => "Software Developer",
                "show" => 1,
            ]
        ];
        $pipeline  = $this->obj->searchPipelineCount($searchParam);
        $this->assertEquals($pipeline, 2);
    }
}
