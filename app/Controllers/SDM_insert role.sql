use sdm
--INSERT INTO userrole (userrole_id, role_id, instansi_pengguna_id, create_date, last_update, expired_date) 
select NEWID(), '122F3763-C77D-4CF8-AA07-AD7ED041626A', instansi_pengguna_id, GETDATE(), GETDATE(), NULL
from (
SELECT 
	ROW_NUMBER() OVER(partition by ip.instansi_pengguna_id ORDER BY p.email, r.nama desc) AS rn,
	ip.instansi_pengguna_id, p.pengguna_id, ip.instansi_id, p.nama, p.email, i.nama instansi, r.nama role, ur.userrole_id, r.role_id
FROM pengguna p JOIn instansi_pengguna ip on p.pengguna_id=ip.pengguna_id
join instansi i ON i.instansi_id=ip.instansi_id 
JOIN arsip.dbo.sekolah s ON s.sekolah_id=i.instansi_id AND s.bentuk_pendidikan_id IN (1,2,3,4,5,6,7,8,11,12,13,14,15,18,27,29,30,31,32,33)
LEFT JOIN userrole ur ON ur.instansi_pengguna_id=ip.instansi_pengguna_id AND ur.role_id='122F3763-C77D-4CF8-AA07-AD7ED041626A'
LEFT JOIN role r ON r.role_id=ur.role_id and r.app_id='D1D21323-6C8F-4F30-A005-3FA5DECA4C05'
where p.soft_delete=0 and p.status_approval=1 and ip.soft_delete=0
and i.soft_delete=0
--and i.parent_instansi_id='1809DA48-49C5-4D7B-85B9-9679A568E7DC'
and i.jenis_instansi_id=5
and ur.expired_date IS NULL
AND ur.role_id IS NULL
)x WHERE rn=1

