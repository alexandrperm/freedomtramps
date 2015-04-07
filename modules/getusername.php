<?php
//конвертируем id пользователя в его login
function get_user_by_id($id)
{
	$result_index = mysql_query("SELECT login FROM ft_users WHERE id='$id'");
	$myrow_index = mysql_fetch_array($result_index);
	if($myrow_index!=""){
		return $myrow_index['login'];
	}
	else
		return "";
}

//конвертируем login пользователя в его id
function get_id_by_user($name)
{
	$result_index = mysql_query("SELECT id FROM ft_users WHERE login='$name'");
	$myrow_index = mysql_fetch_array($result_index);
	if($myrow_index!=""){
		return $myrow_index['id'];
	}
	else
		return "";
}

//конвертируем id пользователя в его nik
function get_nik_by_id($id)
{
	$result_index = mysql_query("SELECT p_nik FROM ft_users WHERE id='$id'");
	$myrow_index = mysql_fetch_array($result_index);
	if($myrow_index!=""){
		return $myrow_index['p_nik'];
	}
	else
		return "";
}

//получаем статус пользователя
function get_userstatus($id)
{
	$result_index = mysql_query("SELECT status FROM ft_users WHERE id='$id'");
	$myrow_index = mysql_fetch_array($result_index);
	if($myrow_index!=""){
		return $myrow_index['status'];
	}
	else
		return "";
}
?>