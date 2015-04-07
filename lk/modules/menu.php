<?php
function menu($user_status,$username){

	$sm_read = file("templates/menu.html");//...подключаем шаблон

	//если мы админ, то добавляем еще пункты меню
	if($user_status == ADMIN){
		$sma_read = file("templates/menu_admin.html");//добавляем еще пункты
		$sma_read = implode("",$sma_read);
		$sm_read = str_replace("[_menu_admin]",$sma_read,$sm_read);//производим замену
	}
	else
		$sm_read = str_replace("[_menu_admin]","",$sm_read);//производим замену
	$sm_read = str_replace("[_user_name]",$username,$sm_read);//производим замену	
	$sm_read = implode("",$sm_read);//функция file() возвращаем массив, поэтому склеиваем его
	return $sm_read;//Выводим с генерированный html код
}
?>