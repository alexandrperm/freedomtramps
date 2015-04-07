<?php
//СКРИПТ ПРОВЕРКИ АВТОРИЗАЦИИ
if(isset($_GET['logSESS'])) {$logSESS = $_GET['logSESS'];unset($logSESS);}
if(isset($_POST['logSESS'])) {$logSESS = $_POST['logSESS'];unset($logSESS);}
  session_start();
  $logSESS = $_SESSION['$logSESS'];
  if(!isset($logSESS))
  {
    header("location: login.php");
    exit;  
  }
//СКРИПТ ПРОВЕРКИ АВТОРИЗАЦИИ


//Объявляем переменные, если форма была заполнена и отправленна
if($_POST['name_post'])$name_post = $_POST['name_post'];
if($_POST['txt_post'])$txt_post = $_POST['txt_post'];
//if($_POST['author_post'])$author_post = $_POST['author_post'];
if($_POST['metad_post'])$metad_post = $_POST['metad_post'];
if($_POST['metak_post'])$metak_post = $_POST['metak_post'];
if($_POST['category_post'])$category_post = $_POST['category_post'];//выбор категории поста
if($_POST['nopost_post'])$nopost_post = $_POST['nopost_post'];//добавить в черновики
if($_POST['post_post'])$post_post = $_POST['post_post'];//опубликовать
//Объявляем переменные, если форма была заполнена и отправленна

if($name_post & $txt_post)//Если существуют посланные данные...
{//...то

    $metad_post = htmlspecialchars($metad_post);
    $metak_post = htmlspecialchars($metak_post);
	
    $date_day = date("d");//Определяем день
    $date_month = date("m");//Определяем месяц
    $date_year = date("Y");//Определяем год
    $date_time = date("H:i:s");//Определяем часы и минуты
  
    //получим дату для записи в формате день/месяц/год часы:минуты 
	$date_cont = $date_year."-".$date_month."-".$date_day." ".$date_time;//Склеим все переменные в одну
	

	
    //Избавляемся от кавычки
    $name_post = str_replace("'","&#039",$name_post);
    //$txt_post = str_replace("'","&#039",$txt_post);
    //$author_post = str_replace("'","&#039",$author_post);
	
	$author_post = $logSESS;
	//преобразуем username в id 
	$userid = get_id_by_user($author_post);
	
	$metak_post = str_replace("'","&#039",$metak_post);
    $metad_post = str_replace("'","&#039",$metad_post);
    
	//определяем статус поста
	if(isset($post_post))
		$post_status = 1;//NORMPOST;//норм пост
	if(isset($nopost_post))
		$post_status = 0;//NOPOST;//черновик
    
	
    //ДОБАВЛЯЕМ ПОСТ В БАЗУ ДАННЫХ
    $result_add_cont = mysql_query ("INSERT INTO ft_posts (text,title,userid,date_c,category,meta_d,meta_k,post_status) 
    VALUES ('$txt_post','$name_post','$userid','$date_cont','$category_post','$metad_post','$metak_post','$post_status')");
    //ДОБАВЛЯЕМ ПОСТ В БАЗУ ДАННЫХ
    
    header("location: index.php");//Перенаправление
    exit;//на главную страницу
}




function content_add()
{
$sm_read = file("templates/content_add.html");//...подключаем шаблон
$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его

$allcat = mysql_query("SELECT id,name FROM ft_cat");//Выводим из базы данных 
$categ = mysql_fetch_array($allcat);
if($categ != "")//Если есть категории
{
    do//То формируем список
    {
        $option .= "<option value=\"".$categ['id']."\">".$categ['name']."</option>\n";
    }
    while($categ = mysql_fetch_array($allcat));
}
else $option = "";//Если нет категорий то создаем пустую переменную

$sm_read = str_replace("[_option]",$option,$sm_read);//Меняем код слово на с генерированный список

return $sm_read;//Выводим с генерированный html код
}


?>