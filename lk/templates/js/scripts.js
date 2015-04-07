function tags(step)
{
var window_tags_a = document.getElementById("window_tags_a");
var window_tags_img = document.getElementById("window_tags_img");
//-----------------ОТКРЫТИЕ ФОРМ ДЛЯ ЗАПОЛНЕНИЯ
    if(step == 1) window_tags_a.style.display = "block";//открытие формы для тега [a][/a]
    if(step == 3) window_tags_img.style.display = "block";//открытие формы для тега [img]
//-----------------ОТКРЫТИЕ ФОРМ ДЛЯ ЗАПОЛНЕНИЯ
    
//-----------------ОБРАБОТЧИК ЗАПОЛНЕННЫХ ФОРМ
    if(step == 0) document.getElementById("txt_post").value += "[b][/b]";//BB код [b][/b]
    //------------------
    if(step == 5) document.getElementById("txt_post").value += "[cut]";//BB код [cut] - кнопка "читать дальше"
    //------------------
    if(step == 2)//Вставляем бб код в форму ([a][/a])
    {
        window_tags_a.style.display = "none";//Закрываю всплывающее окно
        var input_link_a = document.getElementById("input_link_a").value;//Сохраняю введенную ссылку
        var input_text_a = document.getElementById("input_text_a").value;//Сохраняю введенный текст
        document.getElementById("txt_post").value += "[a url='"+input_link_a+"']"+input_text_a+"[/a]";//Вставляю в форму bb тег ссылки
        
        //сброс
        document.getElementById("input_link_a").value = "Введите ссылку";
        document.getElementById("input_text_a").value = "Введите текст ссылки";
        //сброс
    }
    //------------------
    if(step == 4)//Вставляем бб код в форму ([img])
    {
        window_tags_img.style.display = "none";//Закрываю всплывающее окно
        var input_link_img = document.getElementById("input_link_img").value;//Сохраняю введенную ссылку
        var radio_pos = document.getElementById("radio_pos").value;//Сохраняю позицию
        document.getElementById("txt_post").value += "[img url='"+input_link_img+"' pos='"+radio_pos+"']";//Вставляю в форму bb тег изображения
        
        //сброс
        for(var i=1;i<=3;i++)document.getElementById("radio_"+i).style.fontWeight = "100";
        document.getElementById("radio_pos").value = "";
        document.getElementById("input_link_img").value = "Введите ссылку";
        //сброс
    }
//-----------------ОБРАБОТЧИК ЗАПОЛНЕННЫХ ФОРМ
}

function pos(pos)
{
//-----------------УПРАВЛЕНИЕ РАСПОЛОЖЕНИЕ ИЗОБРАЖЕНИЯ (ЛЕВО/ПРАВО/ЦЕНТР)
    if(pos == "l")//если лево
    {
        for(var i=1;i<=3;i++)
        {
            if(i==1)document.getElementById("radio_"+i).style.fontWeight = "bold";
            else document.getElementById("radio_"+i).style.fontWeight = "100";
        }
        document.getElementById("radio_pos").value = "l";
    }
    //------------------
    if(pos == "c")//если центр
    {
        for(var i=1;i<=3;i++)
        {
            if(i==2)document.getElementById("radio_"+i).style.fontWeight = "bold";
            else document.getElementById("radio_"+i).style.fontWeight = "100";
        }
        document.getElementById("radio_pos").value = "c";
    }
    //------------------
    if(pos == "r")//если право
    {
        for(var i=1;i<=3;i++)
        {
            if(i==3)document.getElementById("radio_"+i).style.fontWeight = "bold";
            else document.getElementById("radio_"+i).style.fontWeight = "100";
        }
        document.getElementById("radio_pos").value = "r";
    }
//-----------------УПРАВЛЕНИЕ РАСПОЛОЖЕНИЕ ИЗОБРАЖЕНИЯ (ЛЕВО/ПРАВО/ЦЕНТР)
}

//сообщения для модуля Контакты
function open_mess(id)
{
    var IDmess = document.getElementById("mess_"+id);
    if(IDmess.style.display == "none")IDmess.style.display = "block";
    else IDmess.style.display = "none";
}