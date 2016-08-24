<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set("date.timezone", "America/New_York");
error_reporting(E_ALL); 
$db = @mysql_connect ('southeastern.db.7442343.hostedresource.com','southeastern','TangoRomeo@65');
mysql_select_db('southeastern',$db); 
mysql_set_charset('utf8',$db);
@session_start();
?>