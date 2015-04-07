<?php
if($_GET['edd_comm'])$edd_comm = $_GET['edd_comm'];


//--------------РЕДАКТИРОВАНИЕ КОММЕНТАРИЕВ
if(isset($_POST['eddname_comm']))$eddname_comm = $_POST['eddname_comm'];
if(isset($_POST['eddtxt_comm']))$eddtxt_comm = $_POST['eddtxt_comm'];
if(isset($_POST['eddid_post']))$eddid_post = $_POST['eddid_post'];
if(isset($eddname_comm) & isset($eddtxt_comm))//Если форма была заполнена и нажата кнопка "Отправить"
{
    //Переводим html код (если есть) в каракозябры =)
    $eddname_comm = htmlspecialchars($eddname_comm);
    $eddtxt_comm = htmlspecialchars($eddtxt_comm);
    
    //Избавляемся от кавычки
    $eddname_comm = str_replace("'","&#039",$eddname_comm);
    $eddtxt_comm = str_replace("'","&#039",$eddtxt_comm);
    
    $eddtxt_comm = str_replace("\n","<BR>",$eddtxt_comm);//Заменяем переносы строки на тег <BR>
    
    //обновляем сообщение в базе данных
    $edd_commDB = mysql_query ("UPDATE ft_comments SET text='$eddtxt_comm', user='$eddname_comm' WHERE id='$edd_comm'");
    
    header("location: ?page=edd_comm&id=".$eddid_post);//Перенаправляем пользователя
    exit;//обратно к форме с комментариями	
}
//--------------РЕДАКТИРОВАНИЕ КОММЕНТАРИЕВ



//--------------УДАЛЕНИЕ КОММЕНТАРИЕВ
if($_GET['del_comm'])$del_comm = $_GET['del_comm'];
if(isset($del_comm))
{
    $result_del_comm = mysql_query ("DELETE FROM ft_comments WHERE id='$del_comm'");//удаляем комм
    header("location: ?page=edd_comm&id=".$id);//Перенаправляем пользователя
    exit;//обратно к форме с комментариями	
}
//--------------УДАЛЕНИЕ КОММЕНТАРИЕВ




function comments($id)//функция вывода списка комментариев
{
$sm_read = file("templates/comments_list.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

$allcomm = mysql_query("SELECT * FROM ft_comments WHERE post_id='$id'");//Выводим из базы данных все комментарии из определенного блога
$comm_blog = mysql_fetch_array($allcomm);
if($comm_blog != "")//Если комментарии
{
    do//То формируем список
    {
        $copy_tamp = $sm_read;//создаем копию шаблона
        $copy_tamp = str_replace("[_author]",$comm_blog['user'],$copy_tamp);//Автор
        $copy_tamp = str_replace("[_dateG]",$comm_blog['date_ct'],$copy_tamp);//Дата
        $copy_tamp = str_replace("[_text]",$comm_blog['text'],$copy_tamp);//Текст
        $copy_tamp = str_replace("[_id]",$comm_blog['id'],$copy_tamp);//Инфо из колонки ID в табл
        $copy_tamp = str_replace("[_blog]",$comm_blog['post_id'],$copy_tamp);//Инфо из колонки blog в табл
        $res .= $copy_tamp;//объедением результат в одну переменную
    }
    while($comm_blog = mysql_fetch_array($allcomm));
}
else $res = "<p align='center'>Комментариев нет!</p>";//Если нет комментариев то выведем сообщение

return $res;//Выводим с генерированный html код
}

function form_comm($edd_comm)//Функция вывода формы
{
$sm_read = file("templates/comments_edd.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

$commDB = mysql_query("SELECT * FROM ft_comments WHERE id='$edd_comm'");//Выводим из базы данных комментарий
$comm_blog = mysql_fetch_array($commDB);

$sm_read = str_replace("[_author]",$comm_blog['user'],$sm_read);//Автор
$sm_read = str_replace("[_text]",$comm_blog['text'],$sm_read);//Текст
$sm_read = str_replace("[_id]",$comm_blog['id'],$sm_read);//Инфо из колонки ID в табл
$sm_read = str_replace("[_blog]",$comm_blog['post_id'],$sm_read);//Инфо из колонки blog в табл


return $sm_read;//Выводим с генерированный html код
}
?>