<?php
ini_set("open_basedir","/chroot/home/S5146769");



$servername = "localhost";

$username = "S5146769";

$password = "pollosilfigo02";

$dbname = "S5146769";


/* Connessione e selezione del database */

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
