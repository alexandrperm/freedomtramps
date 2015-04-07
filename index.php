<?
//Пока что мы вводим значение переменных в ручную
$header_title = "FreedomTramps";
$header_meta_descr = "Описание страницы";
$header_meta_keyw = "Ключевые слова страницы";

//posts per page
define("POST_PER_PAGE",10);

//post status defines
define("NOPOST",0);//черновик
define("NORMPOST",1);//публиковать и отображать в ленте новостей

//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)
include("modules/db.php");
//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)

include("modules/getusername.php");//

$server_root = "index.php";

$chpu = 0;//настройка включение выключение ЧПУ (1 - вкл; 0 - выкл)

//СКРИПТ ПРОВЕРКИ АВТОРИЗАЦИИ
if(isset($_GET['logSESS'])) {$logSESS = $_GET['logSESS'];unset($logSESS);}
if(isset($_POST['logSESS'])) {$logSESS = $_POST['logSESS'];unset($logSESS);}
  session_start();
  $logSESS = $_SESSION['$logSESS'];
  if(isset($logSESS))
  {
		$auth = $logSESS.", добро пожаловать,<a href=\"lk/exit.php\">(Выход)</a>";
  }
  else
  {
		$auth = "<a href=\"lk/login.php\">Войти</a><a href=\"lk/register.php\">Регистрация</a>";
  }
//end СКРИПТ ПРОВЕРКИ АВТОРИЗАЦИИ


//ЧЕЛОВЕКО-ПОНЯТНЫЙ УРЛ
//include("modules/getchpu.php");
//ЧЕЛОВЕКО-ПОНЯТНЫЙ УРЛ


//GET ПЕРЕМЕННАЯ contact
if(isset($_GET['contact']))
{
    $contact = $_GET['contact'];
    if(!preg_match("/^[1-2]?$/",$contact))
    {
        header("location: index.php");
        exit;
    }
}
//GET ПЕРЕМЕННАЯ contact


//GET ПЕРЕМЕННАЯ cat
if(isset($_GET['cat']))
{
    $cat = $_GET['cat'];
    if(!preg_match("/^[0-9]+$/",$cat))
    {
        header("location: index.php");
        exit;
    }
}
//GET ПЕРЕМЕННАЯ cat



//GET ПЕРЕМЕННАЯ post
if(isset($_GET['post']))
{
    $post = $_GET['post'];
    if(!preg_match("/^[0-9]+$/",$post))
    {
        header("location: index.php");
        exit;
    }
}
//GET ПЕРЕМЕННАЯ post




//МОДУЛЬ анонсов
if(!$post AND !$contact)//Определяем, существует ли $post, если НЕТ то подключаем модуль news.php
{
	include("modules/news.php");
	$txt = index_page();//Выводим результат функции в переменную, которая отобразится на экране пользователя
}//МОДУЛЬ анонсов




//МОДУЛЬ КОНТАКТЫ
if($contact)//Если существует переменная
{//то
include("modules/contacts.php");//подключаем модуль
$txt = contact($contact);//Выводим результат функции в переменную, которая отобразится на экране пользователя
}
//МОДУЛЬ КОНТАКТЫ




//МОДУЛЬ CТАТЕЙ
if($post)
{
	include("modules/posts.php");
	$txt = print_post($post);//Выводим результат функции в переменную, которая отобразится на экране пользователя	
}
//МОДУЛЬ CТАТЕЙ



//МОДУЛЬ КАТЕГОРИЙ
if($cat)
{
include("modules/category.php");
$txt = index_cat($cat);
}
//МОДУЛЬ КАТЕГОРИЙ



//МОДУЛЬ КОММЕНТОВ
if($post)
{
	include("modules/comments.php");
	if(!isset($error_comm))$error_comm = "";
	$comm = comments($post,$error_comm,$logSESS);//Выводим результат функции в переменную
	$txt .= $comm;
}
//МОДУЛЬ КОММЕНТОВ

$urlsite = $server_root;

include("templates/index.html");//Подключение шаблона
?>