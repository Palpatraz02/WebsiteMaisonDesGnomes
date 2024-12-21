<?php


http_response_code(500);


include "res/php/db_conn.php";
session_start();

if (!isset($_SESSION["email"])) {
    print("deleteReservationError");
    exit();
}

$email = $_REQUEST["email"];
if ($email != $_SESSION["email"]) {
    print("deleteReservationError");
    exit();
}



try {

    $apartment = $_REQUEST["apartment"];
    $start = $_REQUEST["start"];
    $end = $_REQUEST["end"];

    $sql = $conn->prepare("DELETE FROM bookings WHERE email = ? AND apartment = ? AND start_date = ? AND end_date = ?");
    $sql->bind_param('ssss', $email, $apartment, $start, $end);
    if ($sql->execute() === TRUE) {
        print("deleteReservationSuccess");
        http_response_code(200);
        $sql->close();
        exit();
    }
    else {
        print("deleteReservationError");
        $sql->close();
        exit();
    }
} catch (Exception $e) {
    print("deleteReservationError");
    $sql->close();
    exit();
}
