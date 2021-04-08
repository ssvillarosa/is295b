<?php

class PipelineSeeder extends Seeder {

    private $pipeline_table = 'pipeline';

    public function run()
    {
        $this->load->library('Seeder');
        $this->seeder->call('JobOrderSeeder');
        $this->seeder->call('ApplicantSeeder');
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table {$this->pipeline_table};");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $pipelines = [
            [
                'id' => 1,
                'job_order_id' => 1,
                'applicant_id' => 1,
                'status' => PIPELINE_STATUS_SOURCED,
                'assigned_to' => 1,
                'rating' => 5,
                'created_by' => 1,
                'created_time' => '2021-03-16 11:52:00',
                'is_deleted' => 0,
            ],[
                'id' => 2,
                'job_order_id' => 1,
                'applicant_id' => 2,
                'status' => PIPELINE_STATUS_FOR_SCREENING,
                'assigned_to' => 1,
                'rating' => 4,
                'created_by' => 1,
                'created_time' => '2021-03-16 11:53:00',
                'is_deleted' => 0,
            ],[
                'id' => 3,
                'job_order_id' => 1,
                'applicant_id' => 3,
                'status' => PIPELINE_STATUS_AWAITING_CV,
                'assigned_to' => 1,
                'rating' => 3,
                'created_by' => 1,
                'created_time' => '2021-03-16 11:54:00',
                'is_deleted' => 0,
            ],[
                'id' => 4,
                'job_order_id' => 1,
                'applicant_id' => 3,
                'status' => PIPELINE_STATUS_AWAITING_CV,
                'assigned_to' => 1,
                'rating' => 3,
                'created_by' => 1,
                'created_time' => '2021-03-16 11:54:00',
                'is_deleted' => 1,
                'deleted_by' => 1,
                'deleted_time' => '2021-03-16 11:55:00',
            ]
        ];
        foreach ($pipelines as $pipeline) {
            $this->db->insert($this->pipeline_table, $pipeline);            
        }
    }
}
