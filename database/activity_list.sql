DROP VIEW IF EXISTS activity_list;
CREATE VIEW activity_list AS
SELECT
    a.id,
    a.timestamp,
    a.pipeline_id,
    a.updated_by,
    u.name,
    u.username,
    a.activity_type,
    a.activity
FROM activity a
LEFT JOIN user u
    ON a.updated_by = u.id;