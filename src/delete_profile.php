<?php


http_response_code(500);


include "res/php/db_conn.php";
session_start();

if (!isset($_SESSION["email"])) {
    print("deleteProfileError");
    exit();
}

$email = $_REQUEST["email"];
if ($email != $_SESSION["email"]) {
    print("deleteProfileError");
    exit();
}

try {

    $conn->autocommit(FALSE);
    $sql = $conn->prepare("DELETE FROM bookings WHERE email = ?");
    $sql->bind_param('s', $email);
    if ($sql->execute() === TRUE) {
        $sql = $conn->prepare("DELETE FROM users WHERE email = ?");
        $sql->bind_param('s', $email);
        if ($sql->execute() === TRUE) {
            print("deleteProfileSuccess");
            http_response_code(200);
            $_SESSION = array();
            session_destroy();
            $sql->close();
            $conn->autocommit(TRUE);
            exit();
        } else {
            print("deleteProfileError");
            $sql->close();
            $conn->rollback();
            exit();
        }
    } else {
        print("deleteProfileError");
        $sql->close();
        $conn->rollback();
        exit();
    }
} catch (Exception $e) {
    print("deleteProfileError");
    $sql->close();
    exit();
}
