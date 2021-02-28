CREATE VIEW applicant_list AS
SELECT 
    a.id,
    a.last_name,
    a.first_name,
    a.email,
    a.primary_phone,
    0 as active_application,
    a.secondary_phone, 
    a.work_phone,
    a.address,
    CASE
        WHEN a.can_relocate=1 THEN 'Yes'
        WHEN a.can_relocate=0 THEN 'No'
        ELSE 'Unknown'
    END AS can_relocate,
    a.current_employer,
    a.source,
    a.best_time_to_call,
    a.current_pay,
    a.desired_pay,
    (SELECT GROUP_CONCAT(concat(s.name,'(',years_of_experience,'y)') SEPARATOR ', ') 
        FROM `applicant_skill` ask
        JOIN skill s ON ask.skill_id=s.id 
        WHERE applicant_id=a.id
    ) AS skills
FROM `applicant` a