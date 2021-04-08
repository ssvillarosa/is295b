TRUNCATE table activity;
TRUNCATE table applicant;
TRUNCATE table applicant_skill;
TRUNCATE table company;
TRUNCATE table event;
TRUNCATE table job_order;
TRUNCATE table job_order_skill;
TRUNCATE table job_order_user;
TRUNCATE table pipeline;
TRUNCATE table registration_skill;
TRUNCATE table registration;
TRUNCATE table skill_category;
TRUNCATE table skill;
TRUNCATE table user;
TRUNCATE table user_log;
INSERT INTO `user` (`id`, `username`, `password`, `role`, `status`, `failed_login`, `email`, `contact_number`, `name`, `address`, `birthday`) VALUES
(1, 'admin', '$2y$10$xOTqiGEIdhNkmvYOOJEEoO/eCgDP2/cMgoLlBRhWfbvg8r2MRbFNi', 1, 1, 0, 'admin@test.com', '999999', 'Super Admin', 'CPU', '1990-01-01');