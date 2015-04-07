<?php
//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)
include("modules/db.php");	
//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ (БД)

//АВТОРИЗАЦИЯ
//уничтожаем переменную с логином и паролем которые были созданы путем ввода их в строку
if (isset ($_GET['loginDB'])) {$loginDB = $_GET['loginDB'];unset($loginDB);}
if (isset ($_GET['passDB'])) {$passDB = $_GET['passDB'];unset($passDB);}

//заносим в отдельные переменные логин и пароль присланных с помощью post запроса
if (isset ($_POST['loginDB'])) {$loginDB = $_POST['loginDB'];}
if (isset ($_POST['passDB'])) {$passDB = $_POST['passDB'];}

if(isset($loginDB) AND isset($passDB))//если существуют логин и пароль
{	
    if(preg_match("/^[a-zA-Z0-9_-]+$/s",$loginDB) AND preg_match("/^[a-zA-Z0-9]+$/s",$passDB))//проверяем их на корректность ввода с помощью регулярных выражений
    {
        $prov = getenv('HTTP_REFERER');//определяем страницу с который пришел запрос
        $prov = str_replace("www.","",$prov);//удаляем www если есть
        preg_match("/(http\:\/\/[-a-z0-9_.]+\/)/",$prov,$prov_pm);//чистим адресс от лишнего, нам необходимо добиться ссылки вот такого вида http://xxxx.ru
        $prov = $prov_pm[1];//заносим чистый адрес в отдельную переменную
        $server_root = str_replace("www.","",$server_root);//удаляем www если есть
	
        if($server_root == $prov)//если адрес нашего блога и адрес страницы с которой был прислан зарос равны
        {
            $passDB = md5($passDB);//шифруем введенный пароль
            
            $resultlp = mysql_query("SELECT login,pass FROM ft_users WHERE login='$loginDB'");//выводим из базы данных логин и пароль
  			$log_and_pass = mysql_fetch_array($resultlp);
            
            if($log_and_pass != "")//если был выведен результат из БД
            {
			
                if($loginDB == $log_and_pass['login'] AND $passDB == $log_and_pass['pass'])//если введенная информация совпадает с информацией из БД
                {
                    session_start();//стартуем сессию
      				$_SESSION['$logSESS'] = $log_and_pass['login'];//создаем глобальную переменную
      				header("location: index.php");//переносим пользователя на главную страницу
      				exit;				
                }
                else//если введеная инфо не совпадает с инфо из БД
                {
					header("location: login.php");//переносим на форму авторизации
                    exit; 				
                }
            }
            else//если не найдено такого юзера в БД
            {
                header("location: login.php");//переносим на форму авторизации
                exit;
            }
        }
        else//если запрос был послан с другого адреса
        {
            header("location: login.php");//переносим на форму авторизации
            exit; 			
        }
    }
    else//если введены не корректный логин и пароль
    {
        header("location:login.php");//переносим на форму авторизации
        exit; 
    }	
}
//АВТОРИЗАЦИЯ


//мета теги
$header_title = "Авторизация";
$header_metaD = "Авторизация";
$header_metaK = "Авторизация";
//мета теги

function form_author()//функция подключения формы
{
    $sm_read = file("templates/login.html");//...подключаем шаблон
    $sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
    
    return $sm_read;//выводим результат
}

$txt = form_author();//вызываем функцию подключения формы

include("templates/index.html");//главный шаблон
?>