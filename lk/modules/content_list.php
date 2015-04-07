<?php
//УДАЛЕНИЕ ПОСТА
if($_GET['del_post'])$del_post = $_GET['del_post'];//Объявляем переменную содержащею ID удаляемого поста

if($del_post)//Если переменная существует то...
{
    $result_del_post = mysql_query ("DELETE FROM ft_posts WHERE id='$del_post'");//...удаляем этот пост
    header("location: ?page=all_content");//Переносим пользователя на страницу с постами
    exit;
}
//УДАЛЕНИЕ ПОСТА



//ОБРАБОТЧИК
//Объявляем переменные, если форма была отправлена
if($_POST['edd_name_post'])$edd_name_post = $_POST['edd_name_post'];
if($_POST['edd_txt_post'])$edd_txt_post = $_POST['edd_txt_post'];
if($_POST['edd_category_post'])$edd_category_post = $_POST['edd_category_post'];
if($_POST['edd_id_post'])$edd_id_post = $_POST['edd_id_post'];
if($_POST['edd_metad_post'])$edd_metad_post = $_POST['edd_metad_post'];
if($_POST['edd_metak_post'])$edd_metak_post = $_POST['edd_metak_post'];
if($_POST['status_post'])$post_status = $_POST['status_post'];//добавить в черновики

//Объявляем переменные, если форма была отправлена

if($edd_name_post & $edd_txt_post)
{
    //Избавляемся от кавычки
    $edd_name_post = str_replace("'","&#039",$edd_name_post);
    $edd_txt_post = str_replace("'","&#039",$edd_txt_post);
	$edd_metak_post = str_replace("'","&#039",$edd_metak_post);
    $edd_metad_post = str_replace("'","&#039",$edd_metad_post);
    //Избавляемся от кавычки	
    $edd_txt_post = str_replace("\n","<BR>",$edd_txt_post);//Заменяем переносы строки на тег <BR>
	
    //ОБНОВЛЯЕМ ПОСТ В БАЗЕ ДАННЫХ
    $edd_post = mysql_query ("UPDATE ft_posts SET text='$edd_txt_post',title='$edd_name_post',category='$edd_category_post', meta_d = '$edd_metad_post', meta_k = '$edd_metak_post', post_status='$post_status' WHERE id='$edd_id_post'");
    //ОБНОВЛЯЕМ ПОСТ В БАЗЕ ДАННЫХ
    
    header("location:index.php");//Перенаправление
    exit;//на страницу списка постов
}
//ОБРАБОТЧИК



function content_list_admin()//Функция вывода списка постов - для админа
{
$sm_read = file("templates/content_list_admin.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить

$result_index = mysql_query("SELECT id,userid,title,category,post_status FROM ft_posts ORDER BY id DESC");//Выводим из базы данных посты
$myrow_index = mysql_fetch_array($result_index);

do
{
    $copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
    
	if($myrow_index[section_id] != 0) {
	
        $result_cat = mysql_query("SELECT name FROM ft_cat WHERE id='$myrow_index[section_id]'");//Выводим из базы имя пункта
        $myrow_cat = mysql_fetch_array($result_cat);
    
        $name_cat = $myrow_cat['name'];
    }
    else $name_cat = "Нет категории";
	
	//преобразуем userid в username
	$username = get_user_by_id($myrow_index['userid']);
	
    //Делаем замены код-слов
	if($myrow_index['post_status'] == 0)
		$copy_tamp = str_replace("[_title]",$myrow_index['title']."[черновик]",$copy_tamp);//Название поста
	else
		$copy_tamp = str_replace("[_title]",$myrow_index['title'],$copy_tamp);//Название поста
    $copy_tamp = str_replace("[_author]",$username,$copy_tamp);//Автор
    $copy_tamp = str_replace("[_id]",$myrow_index['id'],$copy_tamp);//ID постов
	$copy_tamp = str_replace("[_cat]",$name_cat,$copy_tamp);//Имя категории
    
    $list .= $copy_tamp;//Объединяем результат в одну переменную
}
while($myrow_index = mysql_fetch_array($result_index));

$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в шаблон список постов

return $sm_read;//Выводим с генерированный html код
}

function content_list_user($username)//Функция вывода списка постов - для пользователя $username
{
$sm_read = file("templates/content_list_user.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$tamp_while);//Находим в шаблоне тут часть, которую будет ду вайлить

//преобразуем username в id 
$userid = get_id_by_user($username);


if($userid != ""){
	$result_index = mysql_query("SELECT id,title,category,post_status FROM ft_posts WHERE userid='$userid' ORDER BY id DESC");//Выводим из базы данных посты
	$myrow_index = mysql_fetch_array($result_index);
	if($myrow_index == "")
	{
		$sm_read = "<p align=\"center\">Здесь пока пусто :( </p>";
	}
	else
	{
		do
		{
			$copy_tamp = $tamp_while[1];//Сохраняем ту часть которая будет повторяться в отдельную переменную
			if($myrow_index['section_id'] != 0) {
			
				$result_cat = mysql_query("SELECT name FROM ft_cat WHERE id='$myrow_index[section_id]'");//Выводим из базы имя пункта
				$myrow_cat = mysql_fetch_array($result_cat);
			
				$name_cat = $myrow_cat['name'];
			}
			else $name_cat = "Нет категории";
			
			//Делаем замены код-слов
			if($myrow_index['post_status'] == 0)
				$copy_tamp = str_replace("[_title]",$myrow_index['title']."[черновик]",$copy_tamp);//Название поста
			else
				$copy_tamp = str_replace("[_title]",$myrow_index['title'],$copy_tamp);//Название поста
			$copy_tamp = str_replace("[_author]",$username,$copy_tamp);//Автор
			$copy_tamp = str_replace("[_id]",$myrow_index['id'],$copy_tamp);//ID постов
			$copy_tamp = str_replace("[_cat]",$name_cat,$copy_tamp);//Имя категории
			
			$list .= $copy_tamp;//Объединяем результат в одну переменную
		}
		while($myrow_index = mysql_fetch_array($result_index));
		$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$list,$sm_read);//Вставляем в шаблон список постов
	}
}

return $sm_read;//Выводим с генерированный html код
}

function content_edd($id)//Функция вывода выбранного поста
{
$result_index = mysql_query("SELECT * FROM ft_posts WHERE id='$id'");//Выводим из базы данных пост
$myrow_index = mysql_fetch_array($result_index);

$sm_read = file("templates/content_edd.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

	$text_post = $myrow_index['text'];
	$sm_read = str_replace("[_metad]",$myrow_index['meta_d'],$sm_read);//Описание поста
    $sm_read = str_replace("[_metak]",$myrow_index['meta_k'],$sm_read);//Ключевые слова поста
	$sm_read = str_replace("[_title]",$myrow_index['title'],$sm_read);//Название поста
    $sm_read = str_replace("[_text]",$text_post,$sm_read);//Текст поста
    $sm_read = str_replace("[_author]",$myrow_index['userid'],$sm_read);//ID Автор
    $sm_read = str_replace("[_id]",$myrow_index['id'],$sm_read);//ID поста

	//выводим список категорий
	$allcat = mysql_query("SELECT id,name FROM ft_cat");//Выводим из базы данных 
	$cat = mysql_fetch_array($allcat);
	if($cat != "")//Если есть категории
	{
		do//То формируем список
		{
			$option .= "<option ";
			if($cat['id'] == $myrow_index['category']) 
				$option .= " selected ";
			$option .=" value=\"".$cat['id']."\">".$cat['name']."</option>\n";
		}
		while($cat = mysql_fetch_array($allcat));
	}
	else $option = "";//Если нет категорий то создаем пустую переменную
	$sm_read = str_replace("[_option]",$option,$sm_read);//Список
	
	//статус поста
	$option = "<option ";
	if($myrow_index['post_status']==0)
		$option .= " selected ";
	$option .= "value=\"0\">Черновик</option>";
	$option .= "<option ";
	if($myrow_index['post_status']==1)
		$option .= " selected ";
	$option .= "value=\"1\">Опубликованный пост</option>";
	$sm_read = str_replace("[_status_post_option]",$option,$sm_read);//Список
	
	
	
return $sm_read;//Выводим с генерированный html код
}
?>