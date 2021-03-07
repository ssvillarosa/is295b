CREATE VIEW applicant_list AS
SELECT 
    a.id,
    a.last_name,
    a.first_name,
    a.birthday,
    CASE
        WHEN a.civil_status=1 THEN 'Single'
        WHEN a.civil_status=2 THEN 'Married'
        WHEN a.civil_status=3 THEN 'Widowed'
        ELSE 'Unknown'
    END AS civil_status,
    0 AS active_application,
    a.email,
    a.primary_phone,
    a.secondary_phone, 
    a.work_phone,
    a.best_time_to_call,
    a.address,
    CASE
        WHEN a.can_relocate=1 THEN 'Yes'
        WHEN a.can_relocate=0 THEN 'No'
        ELSE 'Unknown'
    END AS can_relocate,
    a.current_employer,
    a.source,
    a.current_pay,
    a.desired_pay,
    (SELECT GROUP_CONCAT(concat(s.name,'(',years_of_experience,'y)') SEPARATOR ', ') 
        FROM `applicant_skill` ask
        JOIN skill s ON ask.skill_id=s.id 
        WHERE applicant_id=a.id
    ) AS skills,
    a.objectives,
    a.educational_background,
    a.professional_experience,
    a.seminars_and_trainings
FROM `applicant` a
WHERE a.is_deleted != 1;