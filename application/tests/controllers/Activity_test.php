<?php

class Activity_test extends TestCase{
    
    public static function setUpBeforeClass(){
        parent::setUpBeforeClass();

        $CI =& get_instance();
        $CI->load->library('Seeder');
        $CI->load->helper('directory');
        $CI->seeder->call('PipelineSeeder');
        $CI->seeder->call('ActivitySeeder');
        // Delete all attachments.
        $path=UPLOAD_DIRECTORY;
        $CI->load->helper("file");
        delete_files($path, true);
        mkdir($path."/1");
        write_file($path.'/.gitkeep', '');
    }
    
    public function setUp(){        
        // Login as admin.
        $this->request(
            'POST',
            'auth/login',
            [
                'username' => 'admin',
                'password' => 'adminpw',
            ]
        );
    }
    
    public function test_activityListByPipeline(){
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        
        $this->assertContains('Software Developer', $page);
        $this->assertContains('Steven Villarosa', $page);
        $this->assertContains('Assigned To: Super Admin', $page);
        $this->assertContains('Change assignment activity', $page);
        $this->assertContains('Status update activity', $page);
        $this->assertContains('Note activity', $page);
    }
    
    public function test_add_changeAssignment(){
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_assigned_to' => 'on',
                'user_select' => 3,
            ]
        );
        $this->assertContains('Success', $result); 
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('Assigned To: Your guest', $page);        
    }
    
    public function test_add_updateStatus(){
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_status' => 'on',
                'status' => 3,
            ]
        );
        $this->assertContains('Success', $result); 
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('Status: For screening', $page);        
    }
    
    public function test_add_updateRating(){
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_rating' => 'on',
                'rateScore' => 1,
            ]
        );
        $this->assertContains('Success', $result);      
    }
    
    public function test_add_addNote(){
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_notes' => 'on',
                'activity_notes' => 'this is a note.',
            ]
        );
        $this->assertContains('Success', $result);
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('this is a note.', $page);    
    }
    
    public function test_add_sendEmail(){
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_email' => 'on',
                'check_copy' => 'on',
                'email_subject' => 'Subject Test',
                'email_from' => 'From@Test.com',
                'email_to' => 'To@Test.com',
                'email_cc' => 'Cc@Test.com',
                'email_reply_to' => 'ReplyTo@Test.com',
                'email_message' => 'Message Test',
            ]
        );
        $this->assertContains('Success', $result);
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('Subject Test', $page);
        $this->assertContains('From@Test.com', $page);
        $this->assertContains('To@Test.com', $page);
        $this->assertContains('Cc@Test.com', $page);
        $this->assertContains('ReplyTo@Test.com', $page);
        $this->assertContains('Message Test', $page);
    }
    
    public function test_add_scheduleEvent(){
        $dateTime = '2021-04-06 21:29:00';
        $dateTimeText = date_format(date_create($dateTime),"M j, Y g:i:s a");
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_event' => 'on',
                'event_title' => 'Test add event',
                'event_assigned_to' => 1,
                'is_public' => 'on',
                'event_time' => '2021-04-06 21:29:00',
                'event_description' => 'Test add event description.',
            ]
        );
        $this->assertContains('Success', $result);
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('Test add event(Public)', $page);
        $this->assertContains('Test add event description', $page);
        $this->assertContains($dateTimeText, $page);
    }
    
    public function test_add_fileUpload(){
        $filename = 'test.docx';
        $filepath = APPPATH.'tests/testfiles/'.$filename;
        $files = [
                'file_attachment' => [
                        'name'     => $filename,
                        'tmp_name' => $filepath,
                ],
        ];
        $this->request->setFiles($files);
        $result = $this->request(
            'POST',
            'activity/add',
            [
                'pipelineId' => 1,
                'check_upload' => 'on',
            ]
        );
        $this->assertContains('Success', $result);
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('test.docx', $page);
    }
    
    public function test_updateEvent(){
        $dateTime = '2021-05-24 10:23:00';
        $dateTimeText = date_format(date_create($dateTime),"M j, Y g:i:s a");
        $result = $this->request(
            'POST',
            'activity/updateEvent',
            [
                'eventId' => 1,
                'event_title' => 'Test update event',
                'event_assigned_to' => 1,
                'public' => '1',
                'event_time' => '2021-05-24 10:23:00',
                'event_description' => 'Test update event description.',
            ]
        );
        $this->assertContains('Success', $result);
        
        $page = $this->request(
            'GET',
            'activity/activityListByPipeline',
            [
                'pipelineId' => 1,
            ]
        );
        $this->assertContains('Test update event(Public)', $page);
        $this->assertContains('Test update event description', $page);
        $this->assertContains($dateTimeText, $page);
    }
    
    public function test_deleteEvent(){
        $result = $this->request(
            'POST',
            'activity/deleteEvent',
            [
                'eventId' => 1,
            ]
        );
        $this->assertContains('Success', $result);
    }
}
