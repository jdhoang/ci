select constraint_name, column_name, referenced_table_name, referenced_column_name
from key_column_usage 
where table_schema='critical_incidents'
and table_name='activity'
