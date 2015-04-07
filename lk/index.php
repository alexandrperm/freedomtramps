<?
//Пока что мы вводим значение переменных в ручную
$header_title = "FreedomTramps";
$header_meta_descr = "Описание страницы";
$header_meta_keyw = "Ключевые слова страницы";

//user status defines
define("BANNED",0);
define("TINY",1);
define("NORMAL",2);
define("ADMIN",777);



//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)
include("modules/db.php");
//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)


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


//определяем статус пользователя
include("../modules/getusername.php");
$user_status = get_userstatus(get_id_by_user($logSESS));


if($_GET['id'])$id = $_GET['id'];//id поста

if($_GET['page'])
	$page = $_GET['page']; 
else 
	$page = "index";//Определяем страницу которая открыта.
//Если переменная не существует значит открыта главная страница


//ГЛАВНОЕ МЕНЮ АДМИНКИ // показываем всегда
include("modules/menu.php");//Подключаем модуль
$lkmenu_txt = menu($user_status,$logSESS);//Помещаем сгенерированный код в переменную
	
//Главная страница 
//показываем страницу приветствия 
if($page == "index")
{
	$txt = file("templates/hello.html");//...подключаем шаблон
	$txt = implode("",$txt);
}


//ДОБАВЛЕНИЕ ПОСТА
if($page == "add_content")//Если открыта страница добавление постов
{
	if($user_status >= NORMAL){
		include("modules/content_add.php");//Подключаем модуль
		$txt = content_add();//Выводим сгенерированный код в переменную
	}
		else
			$txt = "Недостаточно прав для создания поста.";
}
//end ДОБАВЛЕНИЕ ПОСТА

//РЕДАКТОР ПОСТОВ - для юзера и админа
if( $page == "all_content"  || $page =="my_content" || $page == "edd_content" || $page == "edd_cat")
{
	include("modules/content_list.php");//Подключаем наш модуль
	if($page == "my_content")
		$txt = content_list_user($logSESS);//Если пост еще НЕ выбран//показываем список для пользователя $logSESS
	if(($page == "all_content")&&($user_status == ADMIN))
		$txt = content_list_admin();//Если пост еще НЕ выбран // список постов для админа
	if($page == "edd_content")
		$txt = content_edd($id);//Если пост выбран
	
}
//END РЕДАКТОР ПОСТОВ


//СПИСОК КОММЕНТАРИЕВ
if($page == "edd_comm")
{
	if($user_status == ADMIN){
		include("modules/comments.php");
		if(!isset($edd_comm))
			$txt = comments($id);
		else 
			$txt = form_comm($edd_comm);
	}
}
//СПИСОК КОММЕНТАРИЕВ



//СООБЩЕНИЯ через форму контакты
if($page == "contact")
{
	if($user_status == ADMIN){
		include("modules/contact.php");
		$txt = allmess();
	}
}
//СООБЩЕНИЯ


//РЕДАКТИРОВАНИЕ ПРОФИЛЯ - ПЕРСОНАЛЬНЫЕ ДАННЫЕ
if($page == "pers_data"){
	include("modules/profile.php");
	$txt = profile_person($logSESS);
}
//end РЕДАКТИРОВАНИЕ ПРОФИЛЯ - ПЕРСОНАЛЬНЫЕ ДАННЫЕ



include("templates/index.html");//Выводим главный шаблон на экран
?>