    DROP VIEW IF EXISTS event_list;
    CREATE VIEW event_list AS
    SELECT
        e.id,
        e.title,
        e.assigned_to,
        e.description,
        e.is_public,
        e.activity_id,
        a.timestamp,
        a.pipeline_id,
        a.updated_by as created_by_user_id,
        u.name as created_by_user_name,
        e.event_time
    FROM event e
    JOIN activity a
        ON e.activity_id = a.id
    JOIN user u
        ON a.updated_by = u.id
    WHERE
        e.is_deleted != 1;