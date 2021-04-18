CREATE VIEW pipeline_list AS
SELECT
    p.id,
    p.created_time,
    p.job_order_id,
    jo.title,
    p.applicant_id,
    a.last_name,
    a.first_name,
    a.email AS applicant_email,
CASE
    WHEN p.status=1 THEN 'Unset'
    WHEN p.status=2 THEN 'Sourced'
    WHEN p.status=3 THEN 'For screening'
    WHEN p.status=4 THEN 'Awaiting CV'
    WHEN p.status=5 THEN 'CV for review'
    WHEN p.status=6 THEN 'For paper screening'
    WHEN p.status=7 THEN 'For interview'
    WHEN p.status=8 THEN 'For exam'
    WHEN p.status=9 THEN 'Awaiting result'
    WHEN p.status=10 THEN 'Endorsed'
    WHEN p.status=11 THEN 'For JO'
    WHEN p.status=12 THEN 'For PEME'
    WHEN p.status=13 THEN 'Not interested'
    WHEN p.status=14 THEN 'Not exploring'
    WHEN p.status=15 THEN 'Not pursuing'
    WHEN p.status=16 THEN 'Unresponsive'
    WHEN p.status=17 THEN 'No show'
    WHEN p.status=18 THEN 'Not qualified'
    WHEN p.status=19 THEN 'Failed'
    WHEN p.status=20 THEN 'Keep profile'
    WHEN p.status=21 THEN 'Closed'
    ELSE 'Unknown'
END AS status,
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
LEFT JOIN user u ON p.assigned_to=u.id
JOIN company c ON jo.company_id=c.id
WHERE p.is_deleted != 1
ORDER BY p.id ASC;