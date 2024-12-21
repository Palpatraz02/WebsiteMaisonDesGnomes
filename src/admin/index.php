<?php

include "../res/php/db_conn.php";

session_start();

if (session_status() == PHP_SESSION_DISABLED) {

    session_start();
}



$img_path = "../res/img/struttura/";



if (isset($_REQUEST["app"])) {

    $app_attuale = $_REQUEST["app"];
} else {
    $app_attuale = -1;
}

if (isset($_REQUEST["cat"])) {

    $cat = $_REQUEST["cat"];
} else {
    $cat = 0;
}

?>



<!DOCTYPE html>

<html lang="it">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../res/css/simple-lightbox.css?v2.8.0" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />



    <link href="../res/css/animations.css" rel="stylesheet">

    <link href="../res/css/gallery.css" rel="stylesheet">

    <link href="../res/css/index.css" rel="stylesheet">

    <title>Maison Des Gnomes</title>

</head>

<body id="scrollbar">





    <?php



    if (isset($_SESSION["admin"]) and $_SESSION["admin"] == true) {

        include "admin_navbar.php";

        switch ($cat) {

            case 1:

                include "struttura.php";

                break;

            case 2:

                include "appartamenti.php";

                break;
            case 3:

                include "dettagli_app.php";

                break;
            case 4:

                include "profili.php";

                break;
            case 5:

                include "prenotazioni.php";

                break;
            default:

                include "struttura.php";

                break;
        }
    } else {

        echo "<div class='container mt-5'><div class='alert alert-danger' role='alert'>Non hai i permessi per accedere a questa pagina</div></div>";
    }



    ?>



</body>

</html>