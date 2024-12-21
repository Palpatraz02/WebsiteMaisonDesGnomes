<?php

$img_path = "../res/img/struttura/";

http_response_code(500);


function compress($source, $destination, $quality)

{


    $info = getimagesize($source);


    if ($info['mime'] == 'image/jpeg')

        $image = imagecreatefromjpeg($source);


    elseif ($info['mime'] == 'image/gif')

        $image = imagecreatefromgif($source);


    elseif ($info['mime'] == 'image/png')

        $image = imagecreatefrompng($source);


    if ($info[0] > $info[1]) {

        $image = imagescale($image, 1920);
    } else {

        $image = imagescale($image, 1080);
    }


    imagejpeg($image, $destination, $quality);
}

session_start();
if (!isset($_SESSION["admin"])) {

    die("Non sei loggato");
}

if ($_SESSION["admin"] != true) {

    die("Non sei admin");
}

include "../res/php/db_conn.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

switch ($_REQUEST["mode"]) {

    case "add":


        $app_id = $_REQUEST["apartment"];
        $objective = $_REQUEST["objective"];


        $foto = $_FILES['src']['tmp_name'];

        $titolo = $_REQUEST["title"];


        $descr = $_REQUEST["descr"];


        $query = "SHOW TABLE STATUS WHERE name = 'images'";

        $risultato = mysqli_query($conn, $query) or http_response_code(500);

        $next_id = mysqli_fetch_assoc($risultato)["Auto_increment"];


        $src = "img" . $next_id . ".jpg";

        $file_name = $img_path . $src;

        if ($objective == "apartment") {
            $sql = $conn->prepare("INSERT INTO images (src, titolo, descr, app_id, objective) VALUES (?,?,?,?,?)");

            $sql->bind_param('sssis', $src, $titolo, $descr, $app_id, $objective);
        } else {
            $sql = $conn->prepare("INSERT INTO images (src, titolo, descr, objective) VALUES (?,?,?,?)");

            $sql->bind_param('ssss', $src, $titolo, $descr, $objective);
        }


        if ($sql->execute() === TRUE) {

            compress($foto, $file_name, 75);

            http_response_code(201);
        }


        break;

    case "edit":


        $id = $_REQUEST["id"];
        $titolo = $_REQUEST["title"];


        $descr = $_REQUEST["descr"];

        $sql = $conn->prepare("UPDATE images SET titolo = ?, descr = ? WHERE id_img = ?");

        $sql->bind_param('ssi', $titolo, $descr, $id);


        if ($sql->execute() === TRUE) {


            http_response_code(201);
        }

        break;

    case "delete":


        $id = $_REQUEST["id"];
        $src = $_REQUEST["src"];

        $sql = $conn->prepare("DELETE FROM images WHERE id_img = ?");

        $sql->bind_param('i', $id);


        if ($sql->execute() === TRUE) {

            unlink($img_path . $src);

            http_response_code(201);
        }


        break;

    case "add-apartment":


        $img_path = "../res/img/copertine/";


        $title = $_REQUEST["title"];


        $descr = $_REQUEST["descr"];
        $shortdescr = $_REQUEST["shortdescr"];
        $photo = $_FILES['src']['tmp_name'];

        $query = "SHOW TABLE STATUS WHERE name = 'apartments'";

        $risultato = mysqli_query($conn, $query) or http_response_code(500);

        $next_id = mysqli_fetch_assoc($risultato)["Auto_increment"];


        $src = "copertina" . $next_id . ".jpg";

        $file_name = $img_path . $src;


        $sql = $conn->prepare("INSERT INTO apartments (title, descr, short_descr, tumbnail) VALUES (?,?,?,?)");

        $sql->bind_param('ssss', $title, $descr, $shortdescr, $src);


        if ($sql->execute() === TRUE) {

            compress($photo, $file_name, 75);

            http_response_code(201);
        }


        break;
    case "edit-apartment":

        $id = $_REQUEST["id"];
        $title = $_REQUEST["title"];


        $descr = $_REQUEST["descr"];
        $shortdescr = $_REQUEST["shortdescr"];

        $sql = $conn->prepare("UPDATE apartments SET title = ?, descr = ?, short_descr = ? WHERE id = ?");

        $sql->bind_param('sssi', $title, $descr, $shortdescr, $id);


        if ($sql->execute() === TRUE) {

            http_response_code(201);
        }

        break;

    case "delete-apartment":
        $img_path = "../res/img/copertine/";
        $id = $_REQUEST["id"];
        $src = $_REQUEST["src"];


        $conn->autocommit(FALSE);
        $sql = $conn->prepare("DELETE FROM bookings WHERE apartment = ?");
        $sql->bind_param('i', $id);
        if ($sql->execute() === TRUE) {
            $sql = $conn->prepare("DELETE FROM apartments WHERE id = ?");
            $sql->bind_param('i', $id);
            if ($sql->execute() === TRUE) {
                unlink($img_path . $src);
                http_response_code(201);
                $conn->autocommit(TRUE);
            } else {
                $conn->rollback();
            }
        } else {
            $conn->rollback();
        }


        $sql = $conn->prepare("DELETE FROM apartments WHERE id = ?");

        $sql->bind_param('i', $id);


        if ($sql->execute() === TRUE) {

            unlink($img_path . $src);

            http_response_code(201);
        }
        break;

    case "delete-user":
        if ($_SESSION["email"] == $_REQUEST["email"]) {
            http_response_code(500);
            die("Non puoi cancellare il tuo account da qui");
        }

        $email = $_REQUEST["email"];
        $conn->autocommit(FALSE);
        $sql = $conn->prepare("DELETE FROM bookings WHERE email = ?");
        $sql->bind_param('s', $email);
        if ($sql->execute() === TRUE) {
            $sql = $conn->prepare("DELETE FROM users WHERE email = ?");
            $sql->bind_param('s', $email);

            if ($sql->execute() === TRUE) {
                http_response_code(201);
                $conn->autocommit(TRUE);
            } else {
                $conn->rollback();
            }
        } else {
            $conn->rollback();
        }
        break;

    case "edit-user":

        $email = $_REQUEST["email"];
        $name = $_REQUEST["name"];
        $surname = $_REQUEST["surname"];
        $admin = $_REQUEST["admin"];


        $sql = $conn->prepare("UPDATE users SET name = ?, surname = ?, admin = ? WHERE email = ?");

        $sql->bind_param('ssis', $name, $surname, $admin, $email);


        if ($sql->execute() === TRUE) {
            $_SESSION["admin"] = ($admin == 1 ? true : false);

            http_response_code(201);
        }

        break;
    case "delete-booking":
        $email = $_REQUEST["email"];
        $apartment = $_REQUEST["apartment"];
        $start = $_REQUEST["start"];
        $end = $_REQUEST["end"];

        $sql = $conn->prepare("DELETE FROM bookings WHERE email = ? AND apartment = ? AND start_date = ? AND end_date = ?");
        $sql->bind_param('ssss', $email, $apartment, $start, $end);
        if ($sql->execute() === TRUE) {
            http_response_code(201);
        }
        break;
}
$conn->close();
