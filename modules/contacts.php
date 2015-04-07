<?php


//--------------ОБРАБОТЧИК КОНТАКТОВ
$date_day = date("d");//Определяем день
$date_month = date("m");//Определяем месяц
$date_year = date("Y");//Определяем год
$date_time = date("H:i");//Определяем часы и минуты
$date_cont = $date_day."/".$date_month."/".$date_year." ".$date_time;//Склеим все переменные в одну
//получим дату для записи в формате день/месяц/год часы:минуты 

//Определяем посланные переменные из формы
if(isset($_POST['author_contact']))$author_contact = $_POST['author_contact'];
if(isset($_POST['email_contact']))$email_contact = $_POST['email_contact'];
if(isset($_POST['subj_contact']))$subj_contact = $_POST['subj_contact'];
if(isset($_POST['site_contact']))$site_contact = $_POST['site_contact'];
if(isset($_POST['txt_contact']))$txt_contact = $_POST['txt_contact'];

if($author_contact & $email_contact & $subj_contact & $txt_contact)//Если посланные переменные определены как существующие
{
    //Переводим html код (если есть) в каракозябры =)
    //Вообщем то тут несколько лишних строк, но у меня параноя, поэтому я проверяю ВСЕ переменные

    $author_contact = htmlspecialchars($author_contact);
    $email_contact = htmlspecialchars($email_contact);
    $subj_contact = htmlspecialchars($subj_contact);
	$site_contact = htmlspecialchars($site_contact);
    $txt_contact = htmlspecialchars($txt_contact);
    
    //Избавляемся от кавычки
    $author_contact = str_replace("'","&#039",$author_contact);
    $email_contact = str_replace("'","&#039",$email_contact);
    $subj_contact = str_replace("'","&#039",$subj_contact);
	$site_contact = str_replace("'","&#039",$site_contact);
    $txt_contact = str_replace("'","&#039",$txt_contact);
    
    $txt_contact = str_replace("\n","<BR>",$txt_contact);//Заменяем переносы строки на тег <BR>
    
    //ДОБАВЛЯЕМ СООБЩЕНИЕ В БАЗУ ДАННЫХ
    $result_add_cont = mysql_query ("INSERT INTO ft_feedback (user,subj,date_c,email,site,text) 
    VALUES ('$author_contact','$subj_contact','$date_cont','$email_contact','$site_contact','$txt_contact')");
    //ДОБАВЛЯЕМ СООБЩЕНИЕ В БАЗУ ДАННЫХ
    //ИЛИ
    //ООТПРАВЛЯЕМ СООБЩЕНИЕ ПО ПОЧТЕ
    $to = "test@test.ru";//Ваш почтовый адрес
    $txt_contact = $author_contact." <".$email_contact."> Вам пишет: ".$txt_contact;//Приклеиваем к тексту сообщения
    //контактную информацию отправителя
    mail($to,$subj_contact,$txt_contact);//Собственно сама отправка
    //ООТПРАВЛЯЕМ СООБЩЕНИЕ ПО ПОЧТЕ
    
    header("location: index.php?contact=2");//Перенаправляем пользователя
    exit;//к сообщениею об успешной отправки	
}
//--------------ОБРАБОТЧИК КОНТАКТОВ


/*
@$result_meta = mysql_query("SELECT title,meta_k FROM page WHERE id='1'");
@$myrow_meta = mysql_fetch_array($result_meta);

if($myrow_meta != "")
{
    $header_title = $myrow_meta[title]." - Контакты";
    $header_metaD = "Связь с администрацией";
    $header_metaK = $myrow_meta[meta_k];
}*/


function contact($contact)
{
if($contact == 1)//Если пользователь еще не отправлял сообщение
{
    $sm_read = file("templates/contacts.html");//...подключаем шаблон
    $sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
}

if($contact == 2)//Если пользователь уже отправил сообщение
    $sm_read = "<p align='center'>Ваше сообщение отправлено</p>";//Пользователь увидит следующее сообщение

return $sm_read;//Выводим с генерированный html код
}
?>