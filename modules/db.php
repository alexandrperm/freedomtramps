<?php

if(isset($_GET['server_root'])){$server_root = $_GET['server_root'];unset($server_root);}
if(isset($_POST['server_root'])){$server_root = $_POST['server_root'];unset($server_root);}

//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)
$db_name = "freedomtrampsdb";//Название БД
$db_server = "localhost";//Сервер
$db_user = "root";//Имя пользователя БД
$db_pass = "";//Пароль пользователя БД
mysql_select_db($db_name, mysql_connect($db_servrer,$db_user,$db_pass))or die(mysql_error);	

?>