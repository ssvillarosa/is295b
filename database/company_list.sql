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
    (SELECT COUNT(*) FROM job_order jo WHERE jo.company_id=c.id AND jo.status=1 AND jo.is_deleted != 1) as active,
    (SELECT COUNT(*) FROM job_order jo WHERE jo.company_id=c.id AND jo.status=2 AND jo.is_deleted != 1) as on_hold,
    (SELECT COUNT(*) FROM job_order jo WHERE jo.company_id=c.id AND jo.status=3 AND jo.is_deleted != 1) as closed,
    (SELECT COUNT(*) FROM job_order jo WHERE jo.company_id=c.id AND jo.is_deleted != 1) as total
FROM company c
WHERE c.is_deleted != 1;

