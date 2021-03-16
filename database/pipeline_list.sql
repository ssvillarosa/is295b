CREATE VIEW pipeline_list AS
SELECT
    p.id,
    p.job_order_id,
    jo.title,
    p.applicant_id,
    a.last_name,
    a.first_name,
    p.status,
    p.assigned_to,
    u.username,
    u.name,
    p.rating
FROM pipeline p
JOIN job_order jo ON p.job_order_id=jo.id
JOIN applicant a ON p.applicant_id=a.id
JOIN user u ON p.assigned_to=u.id
WHERE p.is_deleted != 1;