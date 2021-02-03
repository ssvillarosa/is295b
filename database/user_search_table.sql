CREATE VIEW user_search_table AS
SELECT `id`, `username`, `password`, 
CASE 
	WHEN `role` = 1 THEN 'Admin'
	WHEN `role` = 2 THEN 'Recruiter'
    ELSE 'Unknown'
END as `role`, 
CASE 
	WHEN `status` = 1 THEN 'Active'
	WHEN `status` = 2 THEN 'Blocked'
    ELSE 'Unknown'
END as `status`, `email`, `contact_number`, `name`, `address`, `birthday` FROM `user` WHERE `status` != 3;