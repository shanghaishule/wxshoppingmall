<?php 

include_once("../data/config/db.php");

$conn= mysql_connect($arr['DB_HOST'],$arr['DB_USER'],$arr['DB_PWD']) or die("连接数据库失败!");
 mysql_select_db($arr['DB_NAME'],$conn);
 mysql_query("set names gbk");

 

?>