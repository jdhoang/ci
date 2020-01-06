
delete from activity_systems where system_id = &id;
delete from ip_addrs_systems where system_id = &id;
delete from users_systems    where system_id = &id;


delete from systems where id = &id;


