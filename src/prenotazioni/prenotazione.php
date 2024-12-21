<?php
session_start();

if (!isset($_SESSION["email"])) {
    print("bookingError");
    exit();
}

$email = $_REQUEST["email"];
$apartment = $_REQUEST["apartment"];
$start_date = $_REQUEST["start-date"];
$end_date = $_REQUEST["end-date"];

if ($_SESSION["email"] != $email) {
    print("bookingError");
    exit();
}

if ($email == "") {
    print("bookingError");
    exit();
}
if ($apartment == "") {
    print("apartmentError");
    exit();
}
if ($start_date == "") {
    print("dateError");
    exit();
}
if ($end_date == "") {
    print("dateError");
    exit();
}

if ($start_date > $end_date) {
    print("dateError");
    exit();
}

if ($start_date < date("Y-m-d")) {
    print("dateError");
    exit();
}

include "../res/php/db_conn.php";


$sql = $conn->prepare("SELECT * FROM bookings WHERE apartment = ? AND ((start_date <= ? AND end_date >= ?))");
$sql->bind_param("iss", $apartment, $end_date, $start_date);

if ($sql->execute() === TRUE) {

    $ris = $sql->get_result();

    if ($ris->num_rows > 0) {

        print("availabilityError");
        $sql->close();
        exit();
    }
}

$sql = $conn->prepare("INSERT INTO bookings (email, apartment, start_date, end_date) VALUES (?, ?, ?, ?)");
$sql->bind_param("siss", $email, $apartment, $start_date, $end_date);

if ($sql->execute() === TRUE) {

    http_response_code(200);
    print("bookingSuccess");
} else {
    print("bookingError");
}

$sql->close();
