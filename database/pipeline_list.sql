CREATE VIEW pipeline_list AS
SELECT
    p.id,
    p.job_order_id,
    jo.title,
    p.applicant_id,
    a.last_name,
    a.first_name,
CASE
    WHEN p.status=1 THEN 'Sourced'
    WHEN p.status=2 THEN 'For screening'
    WHEN p.status=3 THEN 'Awaiting CV'
    WHEN p.status=4 THEN 'CV for review'
    WHEN p.status=5 THEN 'For paper screening'
    WHEN p.status=6 THEN 'For interview'
    WHEN p.status=7 THEN 'For exam'
    WHEN p.status=8 THEN 'Awaiting result'
    WHEN p.status=9 THEN 'Endorsed'
    WHEN p.status=10 THEN 'For JO'
    WHEN p.status=11 THEN 'For PEME'
    WHEN p.status=12 THEN 'Not interested'
    WHEN p.status=13 THEN 'Not exploring'
    WHEN p.status=14 THEN 'Not pursuing'
    WHEN p.status=15 THEN 'Unresponsive'
    WHEN p.status=16 THEN 'No show'
    WHEN p.status=17 THEN 'Not qualified'
    WHEN p.status=18 THEN 'Failed'
    WHEN p.status=19 THEN 'Keep profile'
    WHEN p.status=20 THEN 'Closed'
    ELSE 'Unknown'
END AS status,
    p.assigned_to,
    u.username,
    u.name,
    p.rating
FROM pipeline p
JOIN job_order jo ON p.job_order_id=jo.id
JOIN applicant a ON p.applicant_id=a.id
JOIN user u ON p.assigned_to=u.id
WHERE p.is_deleted != 1;