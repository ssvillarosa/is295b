DROP VIEW IF EXISTS registration_list;
CREATE VIEW registration_list AS
SELECT 
    r.id,
    CASE
        WHEN r.status=1 THEN 'Pending'
        WHEN r.status=2 THEN 'Approved'
        ELSE 'Unknown'
    END AS status,
    r.last_name,
    r.first_name,
    r.birthday,
    CASE
        WHEN r.civil_status=1 THEN 'Single'
        WHEN r.civil_status=2 THEN 'Married'
        WHEN r.civil_status=3 THEN 'Widowed'
        ELSE 'Unknown'
    END AS civil_status,
    0 AS active_application,
    r.email,
    r.primary_phone,
    r.secondary_phone, 
    r.work_phone,
    r.best_time_to_call,
    r.address,
    CASE
        WHEN r.can_relocate=1 THEN 'Yes'
        WHEN r.can_relocate=0 THEN 'No'
        ELSE 'Unknown'
    END AS can_relocate,
    r.current_employer,
    r.source,
    r.current_pay,
    r.desired_pay,
    (SELECT GROUP_CONCAT(concat(s.name,'(',years_of_experience,'y)') SEPARATOR ', ') 
        FROM `registration_skill` ask
        JOIN skill s ON ask.skill_id=s.id 
        WHERE registration_id=r.id
    ) AS skills,
    r.objectives,
    r.educational_background,
    r.professional_experience,
    r.seminars_and_trainings
FROM `registration` r
WHERE 
    r.status = 1
    AND r.is_deleted != 1;