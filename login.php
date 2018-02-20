<?php
//считываем файл XML и создаем переменные

$xml = new DOMDocument("1.0","UTF-8");

$xml->load("users.xml");

$login = $_POST['login'];
$password = $_POST['password'];
$flag = "";
$user = "";


$s = simplexml_import_dom($xml); // Превращаем узел Dom в SimpleXML

//Сверяем данные ввода с БД

for($i = 0; $i<count($s);$i++){
    if($s->user[$i]->login == $login && password_verify($password,$s->user[$i]->password) == true){
        $flag = true;
        $user = $s->user[$i]->name;
    }else{
        $flag = false;
    }
}

if($flag == true){
    session_start();
    $_SESSION['user'] = $user;
    $_SESSION['auth'] = true;
    setcookie('login', $login, time()+60*60*24*30);
    echo "Hello [$user]";
}else{
    echo 'Неверное имя пользователя или пароль';
}

?>