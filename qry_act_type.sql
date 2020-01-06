select at1.val as "Activity Type", at2.val as "ActSub Type", count(*) 
from activity a
     inner join activity_type at1 on at1.id = a.activity_type_id
     inner join act_sub_type at2 on at2.id = a.act_sub_type_id
group by activity_type_id, act_sub_type_id
