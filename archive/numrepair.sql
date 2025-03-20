SELECT 'numrepair'
,COUNT(case WHEN r.Branch_id = '1' THEN 1 ELSE NULL END) as 'hy'
,COUNT(case WHEN r.Branch_id = '2' THEN 1 ELSE NULL END) as 'lr'
,COUNT(case WHEN r.Branch_id = '3' THEN 1 ELSE NULL END) as 'uc'
,COUNT(case WHEN r.Branch_id = '4' THEN 1 ELSE NULL END) as 'st'
,COUNT(case WHEN r.Branch_id = '5' THEN 1 ELSE NULL END) as 'sd'
,COUNT(case WHEN r.Branch_id = '6' THEN 1 ELSE NULL END) as 'sk'
,COUNT(case WHEN r.Branch_id = '7' THEN 1 ELSE NULL END) as 'nt'
,COUNT(case WHEN r.Branch_id = '9' THEN 1 ELSE NULL END) as 'byd'
FROM repair_history r
INNER JOIN branch b ON r.Branch_id = b.Branch_ID
GROUP BY r.Branch_id