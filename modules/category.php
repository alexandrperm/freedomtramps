<?php

@$result_meta = mysql_query("SELECT title FROM ft_posts WHERE id='1'");
@$myrow_meta = mysql_fetch_array($result_meta);

if($myrow_meta != "")
{
    $result_meta_cat = mysql_query("SELECT name FROM ft_cat WHERE id='$cat'");
    $meta_cat = mysql_fetch_array($result_meta_cat);
    
    $header_title = $myrow_meta['title']." - ".$meta_cat['name'];
    $header_meta_descr = $myrow_meta['title']." - ".$meta_cat['name'];
    $header_meta_keyw = $myrow_meta['title']." - ".$meta_cat['name'];
}

function index_cat($cat)
{
$result_index = mysql_query("SELECT * FROM ft_posts WHERE category ='$cat' ORDER BY id DESC");//Выводим из базы данных все записи где колонка cat равна переменной $cat
$myrow_index = mysql_fetch_array($result_index);
if($myrow_index != "")//Проверяем есть ли в базе данных записи
{//Если есть...
	$sm_read = file("templates/news.html");//...подключаем шаблон
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
	do//Цикл do while
	{
		$edd_tamp = $sm_read;//Так как на придется править шаблон,
		//то лучше его сохранить в отдельную переменную, иначе нам придется 
		//пользоваться функцией file() чаще чем 1 раз, а это нагрузка на сервер
		$text = explode("[cut]",$myrow_index['text']);//идентификатор в тексте показывающий, 
		//что после него следует вывести кнопку "читать дальше"

		//Замены идентификаторов на переменные из базы данных
		$edd_tamp = str_replace("[_text]",$text[0],$edd_tamp);//Текст
		$edd_tamp = str_replace("[_title]",$myrow_index['title'],$edd_tamp);//Название статьи
		$edd_tamp = str_replace("[_id]",$myrow_index['id'],$edd_tamp);//id статьи, для вывода в полной статьи
		$edd_tamp = str_replace("[_user]",$myrow_index['user'],$edd_tamp);//Автор статьи
		$edd_tamp = str_replace("[_date_c]",$myrow_index['date_c'],$edd_tamp);//Дата размещения

		$result .= $edd_tamp;// Склеиваем весь с генерированный код в одну переменную
	}
	while($myrow_index = mysql_fetch_array($result_index));
}
else
	$result = "<p align='center'>Нет записей в базе данных</p>";//Если записей нет, то вывести это сообщение
return $result;//Выводим с генерированный html код
}
?>