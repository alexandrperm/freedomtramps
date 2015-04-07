<?php


//ОБРАБОТЧИК
//Объявляем переменные, если форма была отправлена
if($_POST['edd_id'])$edd_id = $_POST['edd_id'];
if($_POST['edd_nik'])$edd_nik = $_POST['edd_nik'];
if($_POST['edd_name'])$edd_name = $_POST['edd_name'];
if($_POST['edd_sex'])$edd_sex = $_POST['edd_sex'];
if($_POST['edd_bdate'])$edd_bdate = $_POST['edd_bdate'];
if($_POST['edd_city'])$edd_city = $_POST['edd_city'];
if($_POST['edd_country'])$edd_country = $_POST['edd_country'];
if($_POST['edd_about'])$edd_about = $_POST['edd_about'];
if($_POST['edd_icq'])$edd_icq = $_POST['edd_icq'];
if($_POST['edd_skype'])$edd_skype = $_POST['edd_skype'];
if($_POST['edd_vk'])$edd_vk = $_POST['edd_vk'];
if($_POST['edd_twit'])$edd_twit = $_POST['edd_twit'];
if($_POST['edd_phone'])$edd_phone = $_POST['edd_phone'];

//главное, чтобы был ник
if($edd_nik)
{
    //Избавляемся от кавычки
    $edd_nik = str_replace("'","&#039",$edd_nik);
    $edd_name = str_replace("'","&#039",$edd_name);
	$edd_sex = str_replace("'","&#039",$edd_sex);
    $edd_bdate = str_replace("'","&#039",$edd_bdate);
	$edd_city = str_replace("'","&#039",$edd_city);
	$edd_country = str_replace("'","&#039",$edd_country);
	$edd_about = str_replace("'","&#039",$edd_about);
	$edd_icq = str_replace("'","&#039",$edd_icq);
	$edd_skype = str_replace("'","&#039",$edd_skype);
	$edd_vk = str_replace("'","&#039",$edd_vk);
	$edd_twit = str_replace("'","&#039",$edd_twit);
	$edd_phone = str_replace("'","&#039",$edd_phone);
	//Избавляемся от кавычки	
	
	$edd_nik = htmlspecialchars($edd_nik);
    $edd_name = htmlspecialchars($edd_name);
    $edd_sex = htmlspecialchars($edd_sex);
	$edd_bdate = htmlspecialchars($edd_bdate);
    $edd_city = htmlspecialchars($edd_city);
	$edd_country = htmlspecialchars($edd_country);
	$edd_about = htmlspecialchars($edd_about);
	$edd_icq = htmlspecialchars($edd_icq);
	$edd_skype = htmlspecialchars($edd_skype);
	$edd_vk = htmlspecialchars($edd_vk);
	$edd_twit = htmlspecialchars($edd_twit);
	$edd_phone = htmlspecialchars($edd_phone);
	

    $edd_pd = mysql_query ("UPDATE ft_users SET p_nik='$edd_nik',p_name='$edd_name',p_sex='$edd_sex', 
	p_bdate = '$edd_bdate', p_city = '$edd_city' , p_country = '$edd_country', p_about = '$edd_about', 
	p_icq = '$edd_icq',p_skype = '$edd_skype',p_vk = '$edd_vk',p_twit = '$edd_twit',p_phone = '$edd_phone' 
	WHERE id='$edd_id'");
    
    header("location:index.php");//Перенаправление
    exit;//на страницу списка постов
}



//Объявляем переменные, если форма была отправлена

function profile_person($username){

	$sm_read = file("templates/profile_person.html");//...подключаем шаблон

	$userid = get_id_by_user($username);
	$result_index = mysql_query("SELECT * FROM ft_users WHERE id='$userid'");//Выводим из базы данных пост
	$myrow_index = mysql_fetch_array($result_index);
	
	$options .= "<option ";
	if($myrow_index['p_sex'] == 1) 
			$options .= " selected ";
	$options .=" value=\"1\">Мужской</option>";
	$options .= "<option ";
	if($myrow_index['p_sex'] == 2) 
			$options .= " selected ";
	$options .=" value=\"2\">Женский</option>";
	
	$sm_read = str_replace("[_id]",$myrow_index['id'],$sm_read);
	$sm_read = str_replace("[_nik]",$myrow_index['p_nik'],$sm_read);
	$sm_read = str_replace("[_name]",$myrow_index['p_name'],$sm_read);
	$sm_read = str_replace("[_option]",$options,$sm_read);
	$sm_read = str_replace("[_bdate]",$myrow_index['p_bdate'],$sm_read);
	$sm_read = str_replace("[_city]",$myrow_index['p_city'],$sm_read);
	$sm_read = str_replace("[_country]",$myrow_index['p_country'],$sm_read);
	$sm_read = str_replace("[_about]",$myrow_index['p_about'],$sm_read);
	$sm_read = str_replace("[_icq]",$myrow_index['p_icq'],$sm_read);
	$sm_read = str_replace("[_skype]",$myrow_index['p_skype'],$sm_read);
	$sm_read = str_replace("[_vk]",$myrow_index['p_vk'],$sm_read);
	$sm_read = str_replace("[_twit]",$myrow_index['p_twit'],$sm_read);
	$sm_read = str_replace("[_phone]",$myrow_index['p_phone'],$sm_read);
	
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
	return $sm_read;//Выводим с генерированный html код
}
?>