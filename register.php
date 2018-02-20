<?php

//считываем файл XML и создаем теги

$xml = new DOMDocument("1.0","UTF-8");

$xml->load("users.xml");

$rootTag = $xml->getElementsByTagName("users")->item(0);
$userTag = $xml->createElement("user");
$loginTag = $xml->createElement("login");
$emailTag = $xml->createElement("email");
$passwordTag = $xml->createElement("password");

$login = $_POST['login'];
$name = $_POST['name'];
$email = $_POST['email'];
$conf_pass = $_POST['conf-password'];
$password = $_POST['password'];


function clean($value = ""){
    $value = trim($value); // удаляем пробелы из начала и конца строки
    $value = stripslashes($value); // удаляем экранированные символы
    $value = strip_tags($value); // удаляем html и PHP теги
    $value = htmlspecialchars($value); // преобразовываем специальные символы в HTML сущности
    return $value;
}

// Проверяем переменные с помощью созданной функции

$name  = clean($name);
$login  = clean($login);
$email  = clean($email);
$conf_pass = clean($conf_pass);
$password = clean($password);

$s = simplexml_import_dom($xml);

//Проверяем существование данных уникальных полей в БД

    for($i = 0; $i<count($s)-1;$i++){
        if($login == $s->user[$i]->login || $email == $s->user[$i]->email){
            echo "Такой пользователь уже есть!";
            $flag = false;
        }
        else{
            $flag = true;
        }
    }

//Проверяем на наличие пустых переменных

if(!empty($login) && !empty($name) && !empty($email) && !empty($conf_pass) && !empty($password) ) {
    if($flag == true){ 
        if($password == $conf_pass){ //сверяем пароли
            $password = password_hash($password, PASSWORD_DEFAULT); //хэшируем если пароли совпали
            $passTag = $xml->createElement("password",$password);
            $userTag->appendChild($passTag);
            $rootTag->appendChild($userTag);
            $logTag = $xml->createElement("login",$login);
            $userTag->appendChild($logTag);
            $rootTag->appendChild($userTag);
            $emlTag = $xml->createElement("email",$email);
            $userTag->appendChild($emlTag);
            $rootTag->appendChild($userTag);
            $nmeTag = $xml->createElement("name",$name);
            $userTag->appendChild($nmeTag);
            $rootTag->appendChild($userTag);
            $xml->save("users.xml");
            echo "Спасибо за регистрацию";
        }else{
            echo "Пароли не совпадают";
        }   
    }
    
}else{
    echo "Заполните поля";
}

?>