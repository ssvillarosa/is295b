CREATE VIEW job_order_list AS
SELECT 
    jo.id,
    jo.title,
    c.name as company, 
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
    jo.priority_level,
    jo.is_deleted
FROM `job_order` jo
    JOIN company c ON jo.company_id = c.id