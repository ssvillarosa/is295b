CREATE VIEW skill_list AS
SELECT 
    s.id,
    s.name,
    s.category_id,
    sc.name AS category_name
FROM skill s
JOIN skill_category sc
    ON s.category_id = sc.id
WHERE s.is_deleted != 1;