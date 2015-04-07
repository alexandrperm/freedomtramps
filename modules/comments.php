<?php
//--------------ОБРАБОТЧИК КОММЕТАРИЕВ
$date_day = date("d");//Определяем день
$date_month = date("m");//Определяем месяц
$date_year = date("Y");//Определяем год
$date_time = date("H:i:s");//Определяем часы и минуты
$date_comm = $date_year."-".$date_month."-".$date_day." ".$date_time;//Склеим все переменные в одну

//Определяем посланные переменные из формы
if(isset($_POST['id_comm']))$id_comm = $_POST['id_comm'];
if(isset($_POST['txt_comm']))$txt_comm = $_POST['txt_comm'];

if(isset($id_comm) & isset($txt_comm))//Если посланные переменные определены как существующие
{
    //Переводим html код (если есть) в каракозябры =)
    //Вообщем то тут несколько лишних строк, но у меня паранойя, поэтому я проверяю ВСЕ переменные
    $id_comm = htmlspecialchars($id_comm);
	
	//проверяем заполняли ли поле текст
    if($txt_comm == "")$error_comm .= "Вы не заполнили поле 'Текст'|";
        
	if(!isset($error_comm))
    {
        //Избавляемся от кавычки
        $id_comm = str_replace("'","&#039",$id_comm);
        //$txt_comm = str_replace("'","&#039",$txt_comm);
        //$txt_comm = str_replace("\n","<BR>",$txt_comm);//Заменяем переносы строки на тег <BR>
    
        //Добавляем сообщение в базу данных
        $result_add_comm = mysql_query ("INSERT INTO ft_comments (user,text,date_c,post_id) 
        VALUES ('$logSESS','$txt_comm','$date_comm','$id_comm')");
    
        header("location:index.php?post=$post#bottom");//Перенаправляем пользователя
        exit;//обратно к форме с комментариями
    }
	
}
//--------------ОБРАБОТЧИК КОММЕТАРИЕВ



function comments($post,$error,$logSESS){
$result_index = mysql_query("SELECT * FROM ft_comments WHERE post_id='$post' ORDER BY id DESC");
//Выводим из базы данных все записи где post_id равен ID поста
$myrow_index = mysql_fetch_array($result_index);
if($myrow_index != "")//Проверяем есть ли в базе данных записи
{//Если есть...
	$sm_read = file("templates/comments.html");//...подключаем шаблон
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
	$i = 0;
	do//Цикл do while
	{
		$comm_array[$i] = array("id" => $myrow_index['id'],
							  "user" => $myrow_index['user'],
							  "text" => $myrow_index['text'],
							  "date" => $myrow_index['date_c'],
							  "mcid" => $myrow_index['mcid']);
		$i++;
	}
	while($myrow_index = mysql_fetch_array($result_index));
	$comm = comments_tree(0,$comm_array,$sm_read,0);//функция формирования сообщений
}
else{
	if(isset($logSESS)) 
		$comm = "<p align='center'>Комментариев нет, Вы будете первым :)</p>";//Если записей нет, то вывести это сообщение
}

//показываем форму комментирования только для зарегистрированных пользователей


if(isset($logSESS)){
	$form = file("templates/comment_form.html");//подключаем шаблон с формой
	$form = implode("",$form);//функция file() возвращаем массив, поэтому склеиваем его
	//Вывод ошибки
	if($error != "")//если есть ошибки
	{
	$error = explode("|",$error);//превращаем строку в массив
	for($i=0;isset($error[$i]);$i++)//цикл формирующий список ошибок
	{
		if($error[$i] != "")$echoERROR .= "<p style='color:red;margin:0px;'>>$error[$i]</p>";//ошибки
	}
	$form = str_replace("[_error]",$echoERROR,$form);//вывод ошибок на экран
	}
	else $form = str_replace("[_error]","",$form);//если ошибок нет, то удаляем код-слово
	//Вывод ошибки
	$form = str_replace("[_id]",$post,$form);//вклеиваем id поста в форму
	$comm .= $form;
}
if(!isset($logSESS)){
	$comm .= "Зарегистрируйтесь для возможности комментирования.";
}

return $comm;//Выводим с генерированный html код
}

/*функция формирования кода древовидных комментариев*/
/*
$main_comm - id главного/корневого комментария
$comm_array - массив всех сообщений в посте
$temp - шаблон, куда вставлять код
$BC - уровень вложенности
*/
function comments_tree($main_comm,$comm_array,$temp,$BC)//Функция формирования html кода пунктов
{
for($i=0;isset($comm_array[$i]);$i++)
{
    if($comm_array[$i]['mcid'] == $main_comm)
    {
        $edd_tamp = $temp;//Так как на придется править шаблон,
        //то лучше его сохранить в отдельную переменную, иначе нам придется 
        //пользоваться функцией file() чаще чем 1 раз, а это нагрузка на сервер

        //Замены идентификаторов на переменные из базы данных
        $style = $BC * 10;//расчет отступа от левого края в пикселях
        
        $edd_tamp = str_replace("[_style]",$style,$edd_tamp);//отступ от края, что бы был вид "дерева"

		$edd_tamp = str_replace("[_text]",$comm_array[$i]['text'],$edd_tamp);//Текст
		$edd_tamp = str_replace("[_user]",$comm_array[$i]['user'],$edd_tamp);//Автор статьи
		$edd_tamp = str_replace("[_date_c]",$comm_array[$i]['date'],$edd_tamp);//Дата размещения
		
        if($BC < 10)//максимальное количество вложенности комм 10
        {
            $newBC = $BC + 1;//увеличиваем уровень вложенности
            $podcomm = comments_tree($comm_array[$i]['id'],$comm_array,$temp,$newBC);//перезапускаем функцию с новыми параметрами
        }
        else $podcomm = "";//принудительно вставляем пустоту в переменную, в которой должны хранится ответы на комм
        
        $edd_tamp = str_replace("[_podcomm]",$podcomm,$edd_tamp);//заменяем код слово на ответ к комментарию
        $comm .= $edd_tamp;// Склеиваем весь с генерированный код в одну переменную
    }
}
if(!isset($comm))return "";//если небыло сформирован html код то выводим пустоту
else return $comm;//выводим html код
}
?>