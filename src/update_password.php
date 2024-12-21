<?php


http_response_code(500);


include "res/php/db_conn.php";
session_start();

if (!isset($_SESSION["email"])) {
    print("updatePasswordError");
    exit();
}




$email = trim($_REQUEST["email"]);
$oldpsw = $_REQUEST["oldpass"];
$newpsw = $_REQUEST["newpass"];
$newconfpsw = $_REQUEST["newconfirm"];

if ($email != $_SESSION["email"]) {
    print("updatePasswordError");
    exit();
}


$psw_regex = "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/";  //8char 1 grande 1 piccolo 1 simbolo


if (!preg_match($psw_regex, $newpsw)) {
    print("passwordError");
    exit();
}


if ($newconfpsw != $newpsw) {
    print("confirmError");
    exit();
}




try {
    $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");


    $sql->bind_param('s', $email);


    if ($sql->execute() === TRUE) {
        $res = $sql->get_result();
        if ($res->num_rows == 0) {
            print("updatePasswordError");
            $sql->close();
            exit();
        }

        $row = $res->fetch_assoc();

        $psw_hash = $row["password"];

        if (password_verify($oldpsw, $psw_hash)) {
            $sql->close();

            $password = password_hash($newpsw, PASSWORD_DEFAULT);
            $sql = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $sql->bind_param('ss', $password, $email);


            if ($sql->execute() === TRUE) {
                print("updatePasswordSuccess");
                $sql->close();
                http_response_code(200);
            } else {
                print("updatePasswordError");
                $sql->close();
                exit();
            }
        } else {
            print("oldPasswordError");
            $sql->close();
            exit();
        }
    }
} catch (Exception $e) {
    print("updatePasswordError");
    exit();
}
