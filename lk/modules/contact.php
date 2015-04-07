<?php
//--------------УДАЛЕНИЕ СООБЩЕНИЯ
if($_GET['del_mess'])$del_mess= $_GET['del_mess'];//Определяем была ли нажата кнопка "удалить"
if(isset($del_mess))//Если нажата то
{
    $result_del_mess = mysql_query ("DELETE FROM ft_feedback WHERE id='$del_mess'");//удаляем сообщение
    header("location: ?page=contact");//Перенаправляем пользователя
    exit;//обратно к сообщениям	
}
//--------------УДАЛЕНИЕ СООБЩЕНИЯ

function allmess()//Функция вывода всех сообщений
{
$sm_read = file("templates/allcontact.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

$messDB = mysql_query("SELECT * FROM ft_feedback");//Выводим из базы данных сообщения
$mess = mysql_fetch_array($messDB);

if($mess != "")//Если сообщения в базе данных есть то
{
    preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$pmtemp);//вырезаем кусочек шаблона что находится между [_while] и [_while]

    do
    {
        $copy_temp = $pmtemp[1];//Создаем копию вырезанного кусочка шаблона

        //Меняем код слова на нужные нам переменные из БД
        $copy_temp = str_replace("[_login]",$mess['login'],$copy_temp);//Автор
        $copy_temp = str_replace("[_email]",$mess['email'],$copy_temp);//e-mail
        $copy_temp = str_replace("[_subj]",$mess['subj'],$copy_temp);//Тема
		$copy_temp = str_replace("[_site]",$mess['site'],$copy_temp);//сайт 
        $copy_temp = str_replace("[_date_c]",$mess['date_c'],$copy_temp);//Дата
        $copy_temp = str_replace("[_text]",$mess['text'],$copy_temp);//Текст
        $copy_temp = str_replace("[_id]",$mess['id'],$copy_temp);//ID
        
        $rTemp .= $copy_temp;//Сохраняем полученные кусочки кода html в одну переменную
    }
    while($mess = mysql_fetch_array($messDB));
    $sm_read = preg_replace("/\[_while\](.*?)\[_while\]/s",$rTemp,$sm_read);//Заменяем в шаблоне все что находится между [_while] и [_while] на с генерированный код
    return $sm_read;//Выводим с генерированный html код
}
else return "<p align='center'>Сообщений нет!</p>";//если сообщений БД нет, то выведим соответсвующее сообщение
}
?>