<?php


http_response_code(500);


include "res/php/db_conn.php";
session_start();


$email = trim($_REQUEST["email"]);

$psw = $_REQUEST["pass"];



if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    print("emailError");
    exit();
}

if ($psw == "") {
    print("passwordError");
    exit();
}
try {
    $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");


    $sql->bind_param('s', $email);


    if ($sql->execute() === TRUE) {
        $res = $sql->get_result();
        if ($res->num_rows == 0) {
            print("loginError");
            $sql->close();
            exit();
        }

        $row = $res->fetch_assoc();

        $psw_hash = $row["password"];

        if (password_verify($psw, $psw_hash)) {

            $_SESSION["logged"] = true;

            $_SESSION["email"] = $email;

            $_SESSION["admin"] = $row["admin"] == 1 ? true : false;

            print("loginSuccess");
            $sql->close();
            http_response_code(200);
        } else {
            print("loginError");
            $sql->close();
            exit();
        }
    }
} catch (Exception $e) {
    print("loginError");
    exit();
}