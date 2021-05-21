<?php

class ApplicantDashboard_test extends TestCase{
    
    public function setUp(){
        // Login as applicant
        $this->request(
            'POST',
            'applicantAuth/login',
            [
                'email' => 'steven@test.com',
                'password' => 'hello',
            ]
        );
    }
    
    public function test_jobs(){
        $output = $this->request('GET','applicant_dashboard/jobs');
        $this->assertContains('<h5 class="card-title">Software Developer</h5>', $output);
        $this->assertContains('<h5 class="card-title">Business Analyst</h5>', $output);
        $this->assertContains('<h5 class="card-title">Quality Assurance</h5>', $output);
    }
    
    public function test_viewJob(){
        $output = $this->request('GET','applicant_dashboard/viewJob?id=1');
        $this->assertContains('Software Developer', $output);
        $this->assertContains('BGC', $output);
        $this->assertContains('Regular', $output);
    }
    
    public function test_recommendations(){
        $output = $this->request('GET','applicant_dashboard/recommendations');
        $this->assertContains('Software Developer', $output);
    }
    
    public function test_myApplications(){
        $output = $this->request('GET','applicant_dashboard/myApplications');
        $this->assertContains('Software Developer', $output);
    }
}