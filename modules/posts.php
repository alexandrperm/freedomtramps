<?php

//@$result_meta = mysql_query("SELECT title FROM page WHERE id='1'");
//@$myrow_meta = mysql_fetch_array($result_meta);

if(/*$myrow_meta != ""*/1)
{
    $result_meta_post = mysql_query("SELECT title,meta_d,meta_k FROM ft_posts WHERE id='$post'");
    $meta_post = mysql_fetch_array($result_meta_post);

	$header_title = /*$myrow_meta['title']." - ".*/$meta_post['title'];
    $header_meta_descr = $meta_post['meta_d'];
    $header_meta_keyw = $meta_post['meta_k'];
}

function print_post($id)
{
$result_index = mysql_query("SELECT * FROM ft_posts WHERE id = '$id'");//Выводим из базы статью
$myrow_index = mysql_fetch_array($result_index);
if($myrow_index != 0)//Проверяем есть ли в базе данных записи
{//Если есть...
	$sm_read = file("templates/posts.html");//...подключаем шаблон
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

	$text = str_replace("[cut]","",$myrow_index['text']);//Удаляем код-слово из текста
	//(напоминаю, что этот [cut] служит нам разделителем текста статьи, это нужно для вклеивания кнопки "Читать дальше")

	//получаем автора по id
	$username = get_user_by_id($myrow_index['userid']);
	
	//Замены идентификаторов на переменные из базы данных
	$sm_read = str_replace("[_text]",$text,$sm_read);//Текст
	$sm_read = str_replace("[_title]",$myrow_index['title'],$sm_read);//Название статьи
	$sm_read = str_replace("[_user]",$username,$sm_read);//Автор статьи
	$sm_read = str_replace("[_date_c]",$myrow_index['date_c'],$sm_read);//Дата размещения
}
else $sm_read = "<p align='center'>Нет записей в базе данных</p>";//Если записей нет, то вывести это сообщение
	return $sm_read;//Выводим с генерированный html код
}
?>