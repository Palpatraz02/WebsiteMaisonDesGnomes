<?php


http_response_code(500);


include "res/php/db_conn.php";
session_start();

if (!isset($_SESSION["email"])) {
    print("updateProfileError");
    exit();
}


$email = trim($_REQUEST["email"]);
$name = trim($_REQUEST["firstname"]);
$surname = trim($_REQUEST["lastname"]);

if ($email != $_SESSION["email"]) {
    print("updateProfileError");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    print("emailError");
    exit();
}

$regex_name = "/[a-zA-Z]{2,30}$/"; 
if (!preg_match($regex_name, $name)) {
    print("nameError");
    exit();
}
if (!preg_match($regex_name, $surname)) {
    print("surnameError");
    exit();
}

$sql = $conn->prepare("UPDATE users SET name = ?, surname = ? WHERE email = ?");

$sql->bind_param('sss', $name, $surname, $email);


if ($sql->execute() === TRUE) {
    print("updateProfileSuccess");
    $sql->close();
    http_response_code(200);
} else {
    print("updateProfileError");
    $sql->close();
    exit();
}
