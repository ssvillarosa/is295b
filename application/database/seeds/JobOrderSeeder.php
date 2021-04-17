<?php

class JobOrderSeeder extends Seeder {

    private $job_order_table = 'job_order';
    private $job_order_skill_table = 'job_order_skill';
    private $job_order_user_table = 'job_order_user';

    public function run()
    {
        $this->load->library('Seeder');
        $this->seeder->call('SkillSeeder');
        $this->seeder->call('UserSeeder');
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0;");
        $this->db->query("TRUNCATE table {$this->job_order_table};");
        $this->db->query("TRUNCATE table {$this->job_order_skill_table};");
        $this->db->query("TRUNCATE table {$this->job_order_user_table};");
        $this->db->query("SET FOREIGN_KEY_CHECKS = 1;");

        $job_orders = [
            [
                'id' => 1,
                'title' => 'Software Developer',
                'company_id' => 1,
                'job_function' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In cursus turpis massa tincidunt dui ut ornare lectus. Lacus viverra vitae congue eu consequat ac felis donec et. Ut tellus elementum sagittis vitae. Sagittis orci a scelerisque purus semper eget duis. Commodo elit at imperdiet dui accumsan sit amet nulla. Platea dictumst vestibulum rhoncus est pellentesque elit. Purus sit amet volutpat consequat mauris nunc. Pulvinar elementum integer enim neque. Dignissim convallis aenean et tortor. Sit amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar. Diam donec adipiscing tristique risus nec feugiat in fermentum. At in tellus integer feugiat scelerisque varius morbi. Vivamus arcu felis bibendum ut tristique. Elementum tempus egestas sed sed risus pretium quam vulputate. Quisque sagittis purus sit amet volutpat consequat mauris nunc congue. Felis eget velit aliquet sagittis id.',
                'requirement' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In cursus turpis massa tincidunt dui ut ornare lectus. Lacus viverra vitae congue eu consequat ac felis donec et. Ut tellus elementum sagittis vitae. Sagittis orci a scelerisque purus semper eget duis. Commodo elit at imperdiet dui accumsan sit amet nulla. Platea dictumst vestibulum rhoncus est pellentesque elit. Purus sit amet volutpat consequat mauris nunc. Pulvinar elementum integer enim neque. Dignissim convallis aenean et tortor. Sit amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar. Diam donec adipiscing tristique risus nec feugiat in fermentum. At in tellus integer feugiat scelerisque varius morbi. Vivamus arcu felis bibendum ut tristique. Elementum tempus egestas sed sed risus pretium quam vulputate. Quisque sagittis purus sit amet volutpat consequat mauris nunc congue. Felis eget velit aliquet sagittis id.',
                'min_salary' => 90000,
                'max_salary' => 150000,
                'location' => 'BGC',
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:21:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 5,
                'priority_level' => 1,
            ],[
                'id' => 2,
                'title' => 'Business Analyst',
                'company_id' => 2,
                'job_function' => 'Volutpat odio facilisis mauris sit. Felis donec et odio pellentesque diam volutpat commodo sed. Adipiscing tristique risus nec feugiat in fermentum posuere urna. At erat pellentesque adipiscing commodo elit at imperdiet dui accumsan. Blandit aliquam etiam erat velit scelerisque. Risus quis varius quam quisque id diam vel quam. Cras sed felis eget velit aliquet. Lectus quam id leo in. Pharetra et ultrices neque ornare. Sit amet porttitor eget dolor morbi non arcu risus. In fermentum posuere urna nec tincidunt praesent semper. Amet mauris commodo quis imperdiet massa tincidunt nunc. Egestas diam in arcu cursus euismod quis viverra. Sit amet porttitor eget dolor morbi non arcu risus quis. Ut placerat orci nulla pellentesque dignissim enim. Magna sit amet purus gravida quis blandit turpis cursus in. Lorem sed risus ultricies tristique nulla aliquet.',
                'requirement' => 'Morbi tincidunt ornare massa eget egestas. Mollis aliquam ut porttitor leo a diam sollicitudin tempor id. Egestas tellus rutrum tellus pellentesque eu tincidunt tortor aliquam nulla. Id donec ultrices tincidunt arcu non sodales neque. Eget duis at tellus at. Sit amet massa vitae tortor condimentum lacinia quis vel eros. Feugiat in ante metus dictum at tempor commodo ullamcorper. Viverra maecenas accumsan lacus vel facilisis. Lectus sit amet est placerat in egestas erat imperdiet sed. Dolor morbi non arcu risus. Semper risus in hendrerit gravida rutrum quisque non tellus orci.',
                'min_salary' => 50000,
                'max_salary' => 90000,
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:22:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 2,
                'priority_level' => 2,
            ],[
                'id' => 3,
                'title' => 'Quality Assurance',
                'company_id' => 1,
                'job_function' => 'Sed viverra ipsum nunc aliquet bibendum enim. Fringilla urna porttitor rhoncus dolor purus non enim praesent. At lectus urna duis convallis convallis tellus. Quis commodo odio aenean sed adipiscing diam donec. Id aliquet risus feugiat in ante metus. Felis eget velit aliquet sagittis id consectetur purus ut faucibus. Cursus sit amet dictum sit amet justo. Aliquet eget sit amet tellus cras adipiscing enim eu turpis. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Nunc eget lorem dolor sed viverra ipsum nunc. Est velit egestas dui id ornare arcu odio.',
                'requirement' => 'In hendrerit gravida rutrum quisque non. Interdum velit laoreet id donec ultrices tincidunt arcu non. Mi in nulla posuere sollicitudin aliquam. Diam quam nulla porttitor massa id neque aliquam vestibulum morbi. Ac placerat vestibulum lectus mauris ultrices eros in. Gravida cum sociis natoque penatibus. Erat imperdiet sed euismod nisi porta lorem mollis aliquam. Sed odio morbi quis commodo odio aenean sed. Pulvinar sapien et ligula ullamcorper malesuada proin libero nunc. A iaculis at erat pellentesque adipiscing commodo elit. Urna id volutpat lacus laoreet non curabitur. Diam phasellus vestibulum lorem sed risus ultricies tristique nulla aliquet. Volutpat sed cras ornare arcu dui vivamus arcu. Cras semper auctor neque vitae. Diam maecenas ultricies mi eget mauris.',
                'min_salary' => 30000,
                'max_salary' => 70000,
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:24:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 1,
                'priority_level' => 3,
            ],[
                'id' => 4,
                'title' => 'Compliance Officer',
                'company_id' => 2,
                'job_function' => 'Lorem Ipsum',
                'requirement' => 'Lorem Ipsum',
                'min_salary' => 50000,
                'max_salary' => 90000,
                'employment_type' => 2,
                'status' => 1,
                'created_time' => '2021-02-05 16:25:00',
                'created_by' => 1,
                'is_deleted' => 1,
                'deleted_time' => '2021-02-05 17:25:00',
                'slots_available' => 1,
                'priority_level' => 4,
            ],
            [
                'id' => 5,
                'title' => 'Software Developer',
                'company_id' => 1,
                'job_function' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In cursus turpis massa tincidunt dui ut ornare lectus. Lacus viverra vitae congue eu consequat ac felis donec et. Ut tellus elementum sagittis vitae. Sagittis orci a scelerisque purus semper eget duis. Commodo elit at imperdiet dui accumsan sit amet nulla. Platea dictumst vestibulum rhoncus est pellentesque elit. Purus sit amet volutpat consequat mauris nunc. Pulvinar elementum integer enim neque. Dignissim convallis aenean et tortor. Sit amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar. Diam donec adipiscing tristique risus nec feugiat in fermentum. At in tellus integer feugiat scelerisque varius morbi. Vivamus arcu felis bibendum ut tristique. Elementum tempus egestas sed sed risus pretium quam vulputate. Quisque sagittis purus sit amet volutpat consequat mauris nunc congue. Felis eget velit aliquet sagittis id.',
                'requirement' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In cursus turpis massa tincidunt dui ut ornare lectus. Lacus viverra vitae congue eu consequat ac felis donec et. Ut tellus elementum sagittis vitae. Sagittis orci a scelerisque purus semper eget duis. Commodo elit at imperdiet dui accumsan sit amet nulla. Platea dictumst vestibulum rhoncus est pellentesque elit. Purus sit amet volutpat consequat mauris nunc. Pulvinar elementum integer enim neque. Dignissim convallis aenean et tortor. Sit amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar. Diam donec adipiscing tristique risus nec feugiat in fermentum. At in tellus integer feugiat scelerisque varius morbi. Vivamus arcu felis bibendum ut tristique. Elementum tempus egestas sed sed risus pretium quam vulputate. Quisque sagittis purus sit amet volutpat consequat mauris nunc congue. Felis eget velit aliquet sagittis id.',
                'min_salary' => 90000,
                'max_salary' => 150000,
                'location' => 'BGC',
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:21:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 5,
                'priority_level' => 1,
            ],[
                'id' => 6,
                'title' => 'Business Analyst',
                'company_id' => 2,
                'job_function' => 'Volutpat odio facilisis mauris sit. Felis donec et odio pellentesque diam volutpat commodo sed. Adipiscing tristique risus nec feugiat in fermentum posuere urna. At erat pellentesque adipiscing commodo elit at imperdiet dui accumsan. Blandit aliquam etiam erat velit scelerisque. Risus quis varius quam quisque id diam vel quam. Cras sed felis eget velit aliquet. Lectus quam id leo in. Pharetra et ultrices neque ornare. Sit amet porttitor eget dolor morbi non arcu risus. In fermentum posuere urna nec tincidunt praesent semper. Amet mauris commodo quis imperdiet massa tincidunt nunc. Egestas diam in arcu cursus euismod quis viverra. Sit amet porttitor eget dolor morbi non arcu risus quis. Ut placerat orci nulla pellentesque dignissim enim. Magna sit amet purus gravida quis blandit turpis cursus in. Lorem sed risus ultricies tristique nulla aliquet.',
                'requirement' => 'Morbi tincidunt ornare massa eget egestas. Mollis aliquam ut porttitor leo a diam sollicitudin tempor id. Egestas tellus rutrum tellus pellentesque eu tincidunt tortor aliquam nulla. Id donec ultrices tincidunt arcu non sodales neque. Eget duis at tellus at. Sit amet massa vitae tortor condimentum lacinia quis vel eros. Feugiat in ante metus dictum at tempor commodo ullamcorper. Viverra maecenas accumsan lacus vel facilisis. Lectus sit amet est placerat in egestas erat imperdiet sed. Dolor morbi non arcu risus. Semper risus in hendrerit gravida rutrum quisque non tellus orci.',
                'min_salary' => 50000,
                'max_salary' => 90000,
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:22:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 2,
                'priority_level' => 2,
            ],[
                'id' => 7,
                'title' => 'Quality Assurance',
                'company_id' => 1,
                'job_function' => 'Sed viverra ipsum nunc aliquet bibendum enim. Fringilla urna porttitor rhoncus dolor purus non enim praesent. At lectus urna duis convallis convallis tellus. Quis commodo odio aenean sed adipiscing diam donec. Id aliquet risus feugiat in ante metus. Felis eget velit aliquet sagittis id consectetur purus ut faucibus. Cursus sit amet dictum sit amet justo. Aliquet eget sit amet tellus cras adipiscing enim eu turpis. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Nunc eget lorem dolor sed viverra ipsum nunc. Est velit egestas dui id ornare arcu odio.',
                'requirement' => 'In hendrerit gravida rutrum quisque non. Interdum velit laoreet id donec ultrices tincidunt arcu non. Mi in nulla posuere sollicitudin aliquam. Diam quam nulla porttitor massa id neque aliquam vestibulum morbi. Ac placerat vestibulum lectus mauris ultrices eros in. Gravida cum sociis natoque penatibus. Erat imperdiet sed euismod nisi porta lorem mollis aliquam. Sed odio morbi quis commodo odio aenean sed. Pulvinar sapien et ligula ullamcorper malesuada proin libero nunc. A iaculis at erat pellentesque adipiscing commodo elit. Urna id volutpat lacus laoreet non curabitur. Diam phasellus vestibulum lorem sed risus ultricies tristique nulla aliquet. Volutpat sed cras ornare arcu dui vivamus arcu. Cras semper auctor neque vitae. Diam maecenas ultricies mi eget mauris.',
                'min_salary' => 30000,
                'max_salary' => 70000,
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:24:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 1,
                'priority_level' => 3,
            ],[
                'id' => 8,
                'title' => 'Compliance Officer',
                'company_id' => 2,
                'job_function' => 'Lorem Ipsum',
                'requirement' => 'Lorem Ipsum',
                'min_salary' => 50000,
                'max_salary' => 90000,
                'employment_type' => 2,
                'status' => 1,
                'created_time' => '2021-02-05 16:25:00',
                'created_by' => 1,
                'is_deleted' => 1,
                'deleted_time' => '2021-02-05 17:25:00',
                'slots_available' => 1,
                'priority_level' => 4,
            ],
            [
                'id' => 9,
                'title' => 'Software Developer',
                'company_id' => 1,
                'job_function' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In cursus turpis massa tincidunt dui ut ornare lectus. Lacus viverra vitae congue eu consequat ac felis donec et. Ut tellus elementum sagittis vitae. Sagittis orci a scelerisque purus semper eget duis. Commodo elit at imperdiet dui accumsan sit amet nulla. Platea dictumst vestibulum rhoncus est pellentesque elit. Purus sit amet volutpat consequat mauris nunc. Pulvinar elementum integer enim neque. Dignissim convallis aenean et tortor. Sit amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar. Diam donec adipiscing tristique risus nec feugiat in fermentum. At in tellus integer feugiat scelerisque varius morbi. Vivamus arcu felis bibendum ut tristique. Elementum tempus egestas sed sed risus pretium quam vulputate. Quisque sagittis purus sit amet volutpat consequat mauris nunc congue. Felis eget velit aliquet sagittis id.',
                'requirement' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In cursus turpis massa tincidunt dui ut ornare lectus. Lacus viverra vitae congue eu consequat ac felis donec et. Ut tellus elementum sagittis vitae. Sagittis orci a scelerisque purus semper eget duis. Commodo elit at imperdiet dui accumsan sit amet nulla. Platea dictumst vestibulum rhoncus est pellentesque elit. Purus sit amet volutpat consequat mauris nunc. Pulvinar elementum integer enim neque. Dignissim convallis aenean et tortor. Sit amet mauris commodo quis imperdiet massa tincidunt nunc pulvinar. Diam donec adipiscing tristique risus nec feugiat in fermentum. At in tellus integer feugiat scelerisque varius morbi. Vivamus arcu felis bibendum ut tristique. Elementum tempus egestas sed sed risus pretium quam vulputate. Quisque sagittis purus sit amet volutpat consequat mauris nunc congue. Felis eget velit aliquet sagittis id.',
                'min_salary' => 90000,
                'max_salary' => 150000,
                'location' => 'BGC',
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:21:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 5,
                'priority_level' => 1,
            ],[
                'id' => 10,
                'title' => 'Business Analyst',
                'company_id' => 2,
                'job_function' => 'Volutpat odio facilisis mauris sit. Felis donec et odio pellentesque diam volutpat commodo sed. Adipiscing tristique risus nec feugiat in fermentum posuere urna. At erat pellentesque adipiscing commodo elit at imperdiet dui accumsan. Blandit aliquam etiam erat velit scelerisque. Risus quis varius quam quisque id diam vel quam. Cras sed felis eget velit aliquet. Lectus quam id leo in. Pharetra et ultrices neque ornare. Sit amet porttitor eget dolor morbi non arcu risus. In fermentum posuere urna nec tincidunt praesent semper. Amet mauris commodo quis imperdiet massa tincidunt nunc. Egestas diam in arcu cursus euismod quis viverra. Sit amet porttitor eget dolor morbi non arcu risus quis. Ut placerat orci nulla pellentesque dignissim enim. Magna sit amet purus gravida quis blandit turpis cursus in. Lorem sed risus ultricies tristique nulla aliquet.',
                'requirement' => 'Morbi tincidunt ornare massa eget egestas. Mollis aliquam ut porttitor leo a diam sollicitudin tempor id. Egestas tellus rutrum tellus pellentesque eu tincidunt tortor aliquam nulla. Id donec ultrices tincidunt arcu non sodales neque. Eget duis at tellus at. Sit amet massa vitae tortor condimentum lacinia quis vel eros. Feugiat in ante metus dictum at tempor commodo ullamcorper. Viverra maecenas accumsan lacus vel facilisis. Lectus sit amet est placerat in egestas erat imperdiet sed. Dolor morbi non arcu risus. Semper risus in hendrerit gravida rutrum quisque non tellus orci.',
                'min_salary' => 50000,
                'max_salary' => 90000,
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:22:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 2,
                'priority_level' => 2,
            ],[
                'id' => 11,
                'title' => 'Quality Assurance',
                'company_id' => 1,
                'job_function' => 'Sed viverra ipsum nunc aliquet bibendum enim. Fringilla urna porttitor rhoncus dolor purus non enim praesent. At lectus urna duis convallis convallis tellus. Quis commodo odio aenean sed adipiscing diam donec. Id aliquet risus feugiat in ante metus. Felis eget velit aliquet sagittis id consectetur purus ut faucibus. Cursus sit amet dictum sit amet justo. Aliquet eget sit amet tellus cras adipiscing enim eu turpis. Odio ut enim blandit volutpat maecenas volutpat blandit aliquam etiam. Nunc eget lorem dolor sed viverra ipsum nunc. Est velit egestas dui id ornare arcu odio.',
                'requirement' => 'In hendrerit gravida rutrum quisque non. Interdum velit laoreet id donec ultrices tincidunt arcu non. Mi in nulla posuere sollicitudin aliquam. Diam quam nulla porttitor massa id neque aliquam vestibulum morbi. Ac placerat vestibulum lectus mauris ultrices eros in. Gravida cum sociis natoque penatibus. Erat imperdiet sed euismod nisi porta lorem mollis aliquam. Sed odio morbi quis commodo odio aenean sed. Pulvinar sapien et ligula ullamcorper malesuada proin libero nunc. A iaculis at erat pellentesque adipiscing commodo elit. Urna id volutpat lacus laoreet non curabitur. Diam phasellus vestibulum lorem sed risus ultricies tristique nulla aliquet. Volutpat sed cras ornare arcu dui vivamus arcu. Cras semper auctor neque vitae. Diam maecenas ultricies mi eget mauris.',
                'min_salary' => 30000,
                'max_salary' => 70000,
                'employment_type' => 1,
                'status' => 1,
                'created_time' => '2021-02-05 16:24:00',
                'created_by' => 1,
                'is_deleted' => 0,
                'slots_available' => 1,
                'priority_level' => 3,
            ],[
                'id' => 12,
                'title' => 'Compliance Officer',
                'company_id' => 2,
                'job_function' => 'Lorem Ipsum',
                'requirement' => 'Lorem Ipsum',
                'min_salary' => 50000,
                'max_salary' => 90000,
                'employment_type' => 2,
                'status' => 1,
                'created_time' => '2021-02-05 16:25:00',
                'created_by' => 1,
                'is_deleted' => 1,
                'deleted_time' => '2021-02-05 17:25:00',
                'slots_available' => 1,
                'priority_level' => 4,
            ]
        ];
        foreach ($job_orders as $job_order) {
            $this->db->insert($this->job_order_table, $job_order);            
        }
        
        $job_order_skills= [
            [
                'job_order_id' => 1,
                'skill_id' => 1,
                'years_of_experience' => 8,
            ],
            [
                'job_order_id' => 1,
                'skill_id' => 2,
                'years_of_experience' => 7,
            ],
            [
                'job_order_id' => 1,
                'skill_id' => 3,
                'years_of_experience' => 6,
            ],
            [
                'job_order_id' => 1,
                'skill_id' => 4,
                'years_of_experience' => 5,
            ],
        ];
        foreach ($job_order_skills as $job_order_skill) {
            $this->db->insert($this->job_order_skill_table, $job_order_skill);            
        }
        
        $job_order_users= [
            [
                'job_order_id' => 1,
                'user_id' => 1,
            ],
            [
                'job_order_id' => 2,
                'user_id' => 2,
            ],
            [
                'job_order_id' => 1,
                'user_id' => 3,
            ],
            [
                'job_order_id' => 1,
                'user_id' => 4,
            ],
        ];
        foreach ($job_order_users as $job_order_user) {
            $this->db->insert($this->job_order_user_table, $job_order_user);            
        }
    }
}
