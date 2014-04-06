SET PGPASSWORD=123456

psql -d postgres -U postgres -h 127.0.0.1 -p 5433 -c"\lo_export %1 %2"
psql -d postgres -U postgres -h 127.0.0.1 -p 5433 -c"\lo_unlink %1" 

REM SET PGPASSWORD=uet123
REM psql -d spatial_db -U postgres -h 192.168.0.190 -p 5432 -c"\lo_export %1 %2"
REM psql -d spatial_db -U postgres -h 192.168.0.190 -p 5432 -c"\lo_unlink %1" 
