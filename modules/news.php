<?php
function index_page()
{
$result_index = mysql_query("SELECT * FROM ft_posts ORDER BY id DESC LIMIT 10");//Выводим из базы данных последние 10 записей
$myrow_index = mysql_fetch_array($result_index);
if($myrow_index != "")//Проверяем есть ли в базе данных записи
{//Если есть...
	$sm_read = file("templates/news.html");//...подключаем шаблон
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
	do//Цикл do while
	{
		//проверяем, что пост опубликован
		if($myrow_index['post_status']==1){
			$edd_tamp = $sm_read;//Так как на придется править шаблон,
			//то лучше его сохранить в отдельную переменную, иначе нам придется 
			//пользоваться функцией file() чаще чем 1 раз, а это нагрузка на сервер
			$text = explode("[cut]",$myrow_index['text']);//идентификатор в тексте показывающий, 
			//что после него следует вывести кнопку "читать дальше"

			//получаем автора по id
			$username = get_user_by_id($myrow_index['userid']);
			
			//Замены идентификаторов на переменные из базы данных
			$edd_tamp = str_replace("[_text]",$text[0],$edd_tamp);//Текст
			$edd_tamp = str_replace("[_title]",$myrow_index['title'],$edd_tamp);//Название статьи
			$edd_tamp = str_replace("[_id]",$myrow_index['id'],$edd_tamp);//id статьи, для вывода в полной статьи
			$edd_tamp = str_replace("[_user]",$username,$edd_tamp);//Автор статьи
			$edd_tamp = str_replace("[_date_c]",$myrow_index['date_c'],$edd_tamp);//Дата размещения

			$news .= $edd_tamp;// Склеиваем весь с генерированный код в одну переменную
		}
	}
	while($myrow_index = mysql_fetch_array($result_index));
}
else 
	$news = "<p align='center'>Нет записей в базе данных</p>";//Если записей нет, то вывести это сообщение
return $news;//Выводим с генерированный html код
}
?>