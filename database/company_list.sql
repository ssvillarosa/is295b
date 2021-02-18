CREATE VIEW company_list AS
SELECT 
    c.id,
    c.name,
    c.contact_person,
    c.primary_phone,
    c.secondary_phone,
    c.address,
    c.website,
    c.industry,
    SUM(CASE WHEN jo.status=1 THEN 1 ELSE 0 END) as active,
    SUM(CASE WHEN jo.status=2 THEN 1 ELSE 0 END) as on_hold,
    SUM(CASE WHEN jo.status=3 THEN 1 ELSE 0 END) as closed,
    SUM(1) as total
FROM job_order jo
JOIN company c ON c.id=jo.company_id
WHERE jo.is_deleted != 1
GROUP BY company_id;