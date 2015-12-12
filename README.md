mysql　起動　mysql-ctl start

mysql> の入力画面にする
$ mysql-ctl cli

sudo service apache2 restart

SELECT  vs_id, TRUNCATE( AVG( my_data ) , 0 ) , TRUNCATE( AVG( op_data ) , 0 ) , FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP( data_time ) /300, 0 ) *300 ) 
FROM min_data where data_time >=  FROM_UNIXTIME( TRUNCATE( UNIX_TIMESTAMP( now() ) /300, 0 ) *300 )
GROUP BY TRUNCATE( UNIX_TIMESTAMP( data_time ) /300, 0 )