<?php

class JobOrderModel_seedtest extends UnitTestCase {
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->seeder->call('JobOrderSeeder');
    }
        
    public function setUp(){
        $this->obj = $this->newModel('JobOrderModel');
    }    

    public function test_getJobOrders(){
        $expected = [
            1 => 'Software Developer',
            2 => 'Business Analyst',
            3 => 'Quality Assurance',
        ];
        $jobOrders = $this->obj->getJobOrders();
        $this->assertNotEquals($jobOrders,ERROR_CODE);
        $this->assertNotEmpty($jobOrders);
        foreach ($jobOrders as $jobOrder) {
            if($jobOrder->id > 3){
                return;
            }
            $this->assertEquals($expected[$jobOrder->id], $jobOrder->title);
        }
    }
    
    public function test_getJobOrderById(){
        $id = 2;
        $expected = [
            1 => 'Software Developer',
            2 => 'Business Analyst',
            3 => 'Quality Assurance',
        ];
        $job_order = $this->obj->getJobOrderById($id);
        $this->assertNotEquals($job_order,ERROR_CODE);
        $this->assertNotEmpty($job_order);
        $this->assertEquals($expected[$id], $job_order->title);
    }
    
    public function test_getJobOrdersByIds(){
        $ids = [1,2,3];
        $job_orders = $this->obj->getJobOrdersByIds($ids);
        $this->assertNotEquals($job_orders,ERROR_CODE);
        $this->assertNotEmpty($job_orders);
        $this->assertEquals(3,count($job_orders));
    }
    
    public function test_getJobOrdersByStatus(){
        $job_orders = $this->obj->getJobOrdersByStatus([JOB_ORDER_STATUS_OPEN_TEXT]);
        $this->assertNotEquals($job_orders,ERROR_CODE);
        $this->assertNotEmpty($job_orders);
        $this->assertEquals(JOB_ORDER_STATUS_OPEN_TEXT,$job_orders[0]->status);
    }
    
    public function test_getJobOrdersBySkills(){
        $skillIds = [1];
        $job_orders = $this->obj->getJobOrdersByIds($skillIds);
        $this->assertNotEquals($job_orders,ERROR_CODE);
        $this->assertNotEmpty($job_orders);
        $this->assertEquals(1,count($job_orders));
    }
    
    public function test_addJobOrder(){
        $jobOrder = (object)[
            'title' => 'Compliance Officer II',
            'company_id' => 2,
            'job_function' => 'Lorem Ipsum',
            'requirement' => 'Lorem Ipsum',
            'min_salary' => 50000,
            'max_salary' => 90000,
            'employment_type' => 2,
            'status' => 1,
            'created_by' => 1,
            'is_deleted' => 0,
            'slots_available' => 1,
            'priority_level' => 4,
        ];
        $inserted_id = $this->obj->addJobOrder($jobOrder);
        $newJobOrder  = $this->obj->getJobOrderById($inserted_id);
        $this->assertNotEquals($newJobOrder,ERROR_CODE);
        $this->assertEquals($newJobOrder->title, $jobOrder->title);       
    }
    
    public function test_updateJobOrder(){
        $id = 5;
        $jobOrder = (object)[
            'title' => 'Compliance Officer III',
            'min_salary' => 50000,
            'max_salary' => 90000,
            'slots_available' => 2,
            'priority_level' => 4,
        ];
        $jobOrder1  = $this->obj->getJobOrderById($id);
        $this->assertNotEquals($jobOrder1->title,$jobOrder->title);
        $result = $this->obj->updateJobOrder($jobOrder,$id);
        $this->assertEquals($result,SUCCESS_CODE);
        $updatedJobOrder1 = $this->obj->getJobOrderById($id);
        $this->assertEquals($updatedJobOrder1->title,$jobOrder->title);    
    }
    
    public function test_deleteJobOrder(){
        $jobOrderCount  = $this->obj->getJobOrderCount(); 
        $this->obj->deleteJobOrder(5,1);
        $newCount  = $this->obj->getJobOrderCount();
        $this->assertEquals($newCount, $jobOrderCount-1);    
    }
    
    public function test_searchJobOrder(){
        $searchParam = [
            (object)[
                "field" => "title",
                "condition" => "E",
                "value" => "Software Developer",
                "show" => 1,
            ]
        ];
        $job_order  = $this->obj->searchJobOrder($searchParam,["title"]);
        $this->assertEquals($job_order[0]["title"], "Software Developer");
    }
    
    public function test_searchJobOrderCount(){
        $searchParam = [
            (object)[
                "field" => "title",
                "condition" => "E",
                "value" => "Software Developer",
                "show" => 1,
            ]
        ];
        $job_order  = $this->obj->searchJobOrderCount($searchParam);
        $this->assertEquals(count($job_order), 1);
    }
    
    public function test_getJobOrderByUserId(){
        $jobOrders = $this->obj->getJobOrderByUserId(1);
        $this->assertContains($jobOrders[0]->title,"Software Developer");
    }
}
