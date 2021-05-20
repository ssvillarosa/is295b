DROP VIEW IF EXISTS pipeline_list;
CREATE VIEW pipeline_list AS
SELECT
    p.id,
    p.created_time,
    p.job_order_id,
    jo.title,
    jo.priority_level,
    p.applicant_id,
    a.last_name,
    a.first_name,
    a.email AS applicant_email,
    p.status as status_id,
    ps.status,
    p.assigned_to,
    u.username,
    u.email as user_email,
CASE
    WHEN u.name is NULL THEN 'Unassigned'
    ELSE u.name
END as name,
    p.rating,
    c.name as company_name,
    jo.location,
    jo.min_salary,
    jo.max_salary,
    jo.job_function
FROM pipeline p
JOIN job_order jo ON p.job_order_id=jo.id
JOIN applicant a ON p.applicant_id=a.id
JOIN pipeline_status ps ON p.status=ps.id
LEFT JOIN user u ON p.assigned_to=u.id
JOIN company c ON jo.company_id=c.id
WHERE p.is_deleted != 1
ORDER BY p.id ASC;