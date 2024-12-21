<?php


http_response_code(500);


include "res/php/db_conn.php";
session_start();





$email = trim($_REQUEST["email"]);
$name = trim($_REQUEST["firstname"]);
$surname = trim($_REQUEST["lastname"]);

$psw = $_REQUEST["pass"];
$confirm = $_REQUEST["confirm"];

$regex_name = "/[a-zA-Z]{2,30}$/";
$psw_regex = "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/";  //8char 1 grande 1 piccolo 1 simbolo


if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    print("emailError");
    exit();
}


if (!preg_match($regex_name, $name)) {
    print("nameError");
    exit();
}
if (!preg_match($regex_name, $surname)) {
    print("surnameError");
    exit();
}


if (!preg_match($psw_regex, $psw)) {
    print("passwordError");
    exit();
}


if ($confirm != $psw) {
    print("confirmError");
    exit();
}

$password = password_hash($psw, PASSWORD_DEFAULT);
$sql = $conn->prepare("INSERT INTO users (email, name, surname, password) VALUES (?,?,?,?)");


$sql->bind_param('ssss', $email, $name, $surname, $password);


if ($sql->execute() === TRUE) {
    print("singupSuccess");
    $sql->close();
    http_response_code(200);
} else {
    print("singupError");
    $sql->close();
    exit();
}
