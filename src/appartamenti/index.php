<?php

include "../res/php/db_conn.php";

session_start();

$img_path = "../res/img/struttura/";



if (isset($_REQUEST["app"])) {

    $app_attuale = $_REQUEST["app"];
} else {
    die("Errore appartamento non trovato");
}



?>



<!DOCTYPE html>

<html lang="it">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <link rel="icon" type="image/png" href="../res/img/altro/logo.png" />



    <link href="../res/css/index.css" rel="stylesheet">

    <link href="../res/css/animations.css" rel="stylesheet">

    <link href="../res/css/gallery.css" rel="stylesheet">



    <link rel="stylesheet" href="../res/css/simple-lightbox.css?v2.8.0" />















    <!--

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>



-->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>




    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />

    <!-- Google Fonts -->

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />







    <title>Maison Des Gnomes</title>

</head>

<body id="scrollbar">










    <?php
    include "../res/php/navbar.php";
    ?>

    <div class="container mt-5">


        <?php
        $title = "";
        $descr = "";

        $sql = $conn->prepare("SELECT * FROM apartments WHERE id = ?");


        $sql->bind_param('i', $app_attuale);

        if ($sql->execute() === TRUE) {

            $ris = $sql->get_result()->fetch_assoc();

            $title = $ris["title"];
            $descr = $ris["descr"];
        } else {

            die("Errore appartamento non trovato");
        }

        $sql->close();



        ?>
        <div class="row">

            <div class="column mt-5">



                <h1 class="text-center"><?php echo $title ?></h1>



            </div>

        </div>



        <div class="row">

            <div class="column pt-2" style="background-color: rgba(219,200,26,0.12); border-radius: 10px">



                <p class="some-text"><?php echo $descr; ?></p>



            </div>

        </div>



        <hr class='my-5'>



        <div class="row">

            <div class="col">

                <h2 class="text-center">Galleria</h2>

            </div>

        </div>





        <div class="gallery mt-4 mb-5">

            <?php
            $app = $app_attuale;
            $sql = $conn->prepare("SELECT * FROM images WHERE app_id = ? AND objective = 'apartment'");
            $sql->bind_param('i', $app);


            if ($sql->execute() === TRUE) {
                $ris = $sql->get_result();

                if ($ris->num_rows > 0) {

                    while ($row = $ris->fetch_assoc()) {

                        $src = $row["src"];

                        $titolo = $row["titolo"];

            ?>

                        <div class="img-wrap">

                            <div class="button">



                                <a href="<?php echo $img_path . $src; ?>" class="img-box">



                                    <img src="<?php echo $img_path . $src; ?>" class="w-100 shadow-1-strong rounded" alt="<?php echo $titolo; ?>" title="<?php echo $titolo; ?>" />

                                </a>

                            </div>

                        </div>

            <?php

                    }
                }
            } else {
                echo "Errore immagini non trovate";
            }




            ?>





        </div>



    </div>



    <script src="../res/js/simple-lightbox.js?v2.8.0"></script>





    <script>
        (function() {

            var $gallery = new SimpleLightbox('.img-box', {



                navText: ["<span class='material-icons-round' style='color:white;'>arrow_back</span>", "<span class='material-icons-round' style='color:white;'>arrow_forward</span>"],

                closeText: "<span class='material-icons-round' style='color:white;'>close</span>",

                captions: false,

                alertErrorMessage: 'Immagine non trovata',

                showCounter: false,



            });

        })();
    </script>

    <?php
    include "../res/php/footer.php";
    ?>



</body>

</html>