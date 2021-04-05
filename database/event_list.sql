CREATE VIEW event_list AS
SELECT
    e.id,
    e.title,
    e.description,
    e.is_public,
    a.timestamp,
    a.pipeline_id,
    a.updated_by as created_by_user_id
FROM event e
JOIN activity a
    ON e.activity_id = a.id
WHERE
    e.is_deleted != 1;