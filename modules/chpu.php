<?php
function chpu($url,$dirDB)//функция ЧПУ
{
//$url - имя с помощью которого мы определим id
//$dirDB - режим, с помощью которого мы определим в какой таблице базы данных нам искать
//определяем запрос в зависимости от того какую страницу открывает пользователь (текст поста или категорию)
if($dirDB == "post")$sql = "SELECT post_id FROM posts WHERE post_url = '$url'";//текст поста
//if($dirDB == "category")$sql = "SELECT id FROM menu WHERE nameurl = '$url'";//категория

$result_index = mysql_query($sql);//Выводим из базы статью
$myrow_index = mysql_fetch_array($result_index);

if($myrow_index != "") return $myrow_index['post_id'];//если найдена строчка в БД выводим id
else return "";//если нет, выводим пустоту
}
?>