CREATE VIEW job_order_user_list AS
SELECT
    jo.id,
    jo.title,
    c.name as company, 
    jou.user_id,
CASE
    WHEN jo.status=1 THEN 'Open'
    WHEN jo.status=2 THEN 'On-hold'
    WHEN jo.status=3 THEN 'Closed'
    ELSE 'Unknown'
END AS status,
CASE
    WHEN jo.employment_type=1 THEN 'Regular'
    WHEN jo.employment_type=2 THEN 'Contractual'
    ELSE 'Unknown'
END AS employment_type,
    jo.job_function,
    jo.requirement,
    jo.min_salary,
    jo.max_salary, 
    jo.location,
    jo.slots_available,
    jo.priority_level
FROM `job_order` jo
    JOIN company c ON jo.company_id = c.id
    JOIN job_order_user jou ON jo.id = jou.job_order_id
WHERE 
    jo.is_deleted != 1;