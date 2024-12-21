<?php

include "../res/php/db_conn.php";

session_start();


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



        <div class="row">

            <div class="col mt-5">



                <h1 class="text-center">Prenotazioni</h1>

                <form>
                    <div class="alert alert-success d-none" role="alert" id="reservation-success">
                        Prenotazione efettuata correttamente!
                    </div>
                    <div class="alert alert-warning d-none" role="alert" id="reservation-availability-error">
                        Errore mancanza disponibilità!
                    </div>
                    <div class="alert alert-warning d-none" role="alert" id="reservation-error">
                        Errore prenotazione!
                    </div>

                    <input type="hidden" name="email" id="email" value="<?php echo $_SESSION["email"] ?>">
                    <div class="mt-3">
                        <label for="apartment">Appartamento</label>
                        <select class="form-control" name="apartment" id="apartment">
                            <?php
                            $sql = $conn->prepare("SELECT * FROM apartments");
                            if ($sql->execute() === TRUE) {
                                $ris = $sql->get_result();
                                if ($ris->num_rows > 0) {
                                    while ($row = $ris->fetch_assoc()) {
                                        echo "<option value=\"" . $row["id"] . "\">" . $row["title"] . "</option>";
                                    }
                                }
                            }
                            ?>

                        </select>
                        <div class="invalid-feedback">
                            Controlla l'appartamento!
                        </div>
                    </div>
                    <div class="mt-3">

                        <label for="start-date" class="form-label">Data inizio</label>
                        <input class="form-control" type="date" id="start-date">
                        <div class="invalid-feedback">
                            Controlla la data di inizio soggiorno!
                        </div>


                    </div>
                    <div class="mt-3">

                        <label for="end-date" class="form-label">Data fine</label>
                        <input class="form-control" type="date" id="end-date">
                        <div class="invalid-feedback">
                            Controlla la data di fine soggiorno!
                        </div>
                    </div>
                    <div class="mt-3">

                        <button type="button" type="button" class="btn btn-primary" id="book">Prenota ora</button>
                    </div>
                </form>



            </div>

        </div>

    </div>



    </div>



    <?php
    include "../res/php/footer.php";
    ?>



</body>

</html>

<script>
    document.querySelector("#book").onclick = function() {
        let successMsg = document.querySelector("#reservation-success");
        let availabilityError = document.querySelector("#reservation-availability-error");
        let errorMsg = document.querySelector("#reservation-error");
        let apartment = document.querySelector("#apartment");
        let startDate = document.querySelector("#start-date");
        let endDate = document.querySelector("#end-date");

        successMsg.classList.replace("d-block", "d-none");
        availabilityError.classList.replace("d-block", "d-none");
        errorMsg.classList.replace("d-block", "d-none");
        apartment.classList.remove("is-invalid");
        startDate.classList.remove("is-invalid");
        endDate.classList.remove("is-invalid");

        let formData = new FormData();
        formData.append("email", document.querySelector("#email").value);
        formData.append("apartment", apartment.value);
        formData.append("start-date", startDate.value);
        formData.append("end-date", endDate.value);

        let url = "prenotazione.php";

        fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(responseText => {
                if (responseText === "bookingSuccess") {
                    successMsg.classList.replace("d-none", "d-block");
                } else {
                    if (responseText === "bookingError") {
                        errorMsg.classList.replace("d-none", "d-block");
                    }
                    if (responseText === "apartmentError") {
                        apartment.classList.add("is-invalid");
                    }
                    if (responseText === "dateError") {
                        startDate.classList.add("is-invalid");
                        endDate.classList.add("is-invalid");
                    }
                    if (responseText === "availabilityError") {
                        availabilityError.classList.replace("d-none", "d-block");
                    }
                }
            })
            .catch(error => {
                errorMsg.classList.replace("d-none", "d-block");
            });



    }
</script>