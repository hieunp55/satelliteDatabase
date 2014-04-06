psql -d spatial_db -U postgres -h 192.168.3.190 -p 5432 -c"\lo_export %1 %2"
psql -d spatial_db -U postgres -h 192.168.3.190 -p 5432 -c"\lo_unlink %1 " 