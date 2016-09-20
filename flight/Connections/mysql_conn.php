<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_mysql_conn = "localhost";
$database_mysql_conn = "flight";
$username_mysql_conn = "root";
$password_mysql_conn = "chellame";
$mysql_conn = mysql_pconnect($hostname_mysql_conn, $username_mysql_conn, $password_mysql_conn) or trigger_error(mysql_error(),E_USER_ERROR); 
?>