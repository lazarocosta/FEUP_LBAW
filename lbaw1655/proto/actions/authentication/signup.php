<?php
include_once('../../config/init.php');
include_once('../../database/users.php');

$username = trim(strip_tags($_POST['username']));
$password= trim(strip_tags($_POST['password']));
$phoneNumber = trim(strip_tags($_POST['phoneNumber']));
$address = trim(strip_tags($_POST['address']));
$birthDate = trim(strip_tags($_POST['birthDate']));
$name = trim(strip_tags($_POST['name']));

if(!hasUsername($usermame)){

    if(!hasAddress($address))
    {
        try {
            $msg = addUser($username, $name, $birthDate, $address, $password, $phoneNumber);

            if($msg != '')
                throw new PDOException($msg);

            $_SESSION['success_messages'][] = 'User registered successfully.';
            header('Location: ../../pages/authentication/homepage.php');

        }catch (PDOException $e){
            $_SESSION['error_messages'][] = $msg;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
    else {
        $_SESSION['error_messages'][] = 'Address already used.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
 else {
     $_SESSION['error_messages'][] = 'That username has already been taken. Please, insert a new one.';
     header('Location: ' . $_SERVER['HTTP_REFERER']);
     exit;
 }


