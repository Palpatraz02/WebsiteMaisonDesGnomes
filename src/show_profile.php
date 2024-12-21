<?php

session_start();
if (!isset($_SESSION["logged"])) {
    header("Location: /");
}


include "res/php/db_conn.php";


$img_path = "res/img/struttura/";

?>


<!DOCTYPE html>

<html lang="it">

<head>


    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="../res/img/altro/logo.png" />


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


    <link href="res/css/animations.css" rel="stylesheet">

    <link href="res/css/gallery.css" rel="stylesheet">

    <link href="res/css/index.css" rel="stylesheet">


    <title>Maison Des Gnomes</title>

</head>

<body id="scrollbar">


    <?php
    include "res/php/navbar.php";


    $sql = $conn->prepare("SELECT * FROM users WHERE email = ?");


    $sql->bind_param('s', $_SESSION["email"]);


    if ($sql->execute() === TRUE) {

        $row = $sql->get_result()->fetch_assoc();


        $email = $row["email"];
        $name = $row["name"];
        $surname = $row["surname"];
    }

    $sql->close();
    ?>

    <div class="container mt-5">

        <div class="row">

            <div class="col mt-5">

                <h1 class="text-center">Profilo</h1>

            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="alert alert-warning d-none" role="alert" id="delete-profile-error">
                    Errore durante l'eliminazione del profilo!
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col mt-5 d-flex justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informazioni utente</h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?php echo $email; ?></h6>
                        <p class="card-text">
                            Nome: <?php echo $name; ?><br>
                            Cognome: <?php echo $surname; ?><br>
                            Email: <?php echo $email; ?>
                        </p>
                        <div class="d-flex justify-content-between buttons">
                            <a class="btn btn-danger btn-square button" id="delete-user-button" data-user-email="<?php echo $row["email"]; ?>"><span class='material-icons-round text-white'>delete</span></a>
                            <a class="btn btn-warning btn-square button" data-bs-toggle="modal" data-bs-target="#form-user" data-bs-email="<?php echo $row["email"]; ?>" data-bs-name="<?php echo $row["name"]; ?>" data-bs-surname="<?php echo $row["surname"]; ?>"><span class='material-icons-round text-white'>edit</span></a>
                            <a class="btn btn-warning btn-square button" data-bs-toggle="modal" data-bs-target="#form-psw"><span class='material-icons-round text-white'>key</span></a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col mt-5 d-flex justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Prenotazioni</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Future</h6>
                        <?php
                        $sql = $conn->prepare("SELECT email, apartment, start_date, end_date, title FROM bookings JOIN apartments ON apartment = id WHERE email = ? AND start_date >= CURDATE() ORDER BY start_date ASC");

                        $sql->bind_param('s', $_SESSION["email"]);

                        if ($sql->execute() === TRUE) {
                            $ris = $sql->get_result();

                            if ($ris->num_rows > 0) {
                                echo "<ul>";
                                while ($row = $ris->fetch_assoc()) {
                        ?>
                                    <li>
                                        <p class="card-text">
                                            <?php echo $row["title"] ?> dal <?php echo $row["start_date"] ?>
                                            al <?php echo $row["end_date"] ?>
                                        <div class="d-flex justify-content-center buttons">
                                            <a class="btn btn-danger btn-square delete-reservation-button button" data-delete-email="<?php echo $row["email"]; ?>" data-delete-apartment="<?php echo $row["apartment"]; ?>" data-delete-start="<?php echo $row["start_date"] ?>" data-delete-end="<?php echo $row["end_date"] ?>">
                                                <span class='material-icons-round text-white'>delete</span></a>
                                        </div>

                                        </p>

                                    </li>
                                    <hr>
                        <?php
                                }
                                echo "</ul>";
                            } else {
                                echo "<p class=\"card-text\">Nessuna prenotazione</p>";
                            }
                        }
                        $sql->close();

                        ?>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col mt-5 d-flex justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Prenotazioni</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Cronologia</h6>
                        <?php
                        $sql = $conn->prepare("SELECT apartment, start_date, end_date, title FROM bookings JOIN apartments ON apartment = id WHERE email = ? AND start_date < CURDATE() ORDER BY start_date ASC");

                        $sql->bind_param('s', $_SESSION["email"]);

                        if ($sql->execute() === TRUE) {
                            $ris = $sql->get_result();

                            if ($ris->num_rows > 0) {
                                echo "<ul>";
                                while ($row = $ris->fetch_assoc()) {
                        ?>
                                    <li>
                                        <p class="card-text">

                                            <?php echo $row["title"] ?> dal <?php echo $row["start_date"] ?>
                                            al <?php echo $row["end_date"] ?>

                                        </p>

                                    </li>
                                    <hr>
                        <?php
                                }
                                echo "</ul>";
                            } else {
                                echo "<p class=\"card-text\">Nessuna prenotazione</p>";
                            }
                        }
                        $sql->close();

                        ?>


                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="modal fade" id="form-user" tabindex="-1" aria-labelledby="title-form-user" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-form-user">Modifica profilo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="user-form">
                        <div class="alert alert-warning d-none" role="alert" id="edit-profile-error">
                            Errore durante la modifica del profilo!
                        </div>

                        <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                            <label for="user-email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="user-email" name="user-email" disabled>
                        </div>
                        <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                            <label for="user-name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="user-name" name="user-name">
                            <div class="invalid-feedback">
                                Controlla il nome!
                            </div>
                        </div>
                        <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                            <label for="user-surname" class="form-label">Cognome</label>
                            <input type="text" class="form-control" id="user-surname" name="user-surname">
                            <div class="invalid-feedback">
                                Controlla il cognome!
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" id="user-edit-apply">Applica</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="form-psw" tabindex="-1" aria-labelledby="title-form-psw" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title-form-psw">Modifica password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="psw-form">
                        <div class="alert alert-warning d-none" role="alert" id="edit-psw-error">
                            Errore durante la modifica della password!
                        </div>


                        <input type="hidden" name="psw-email" id="psw-email" value="<?php echo $_SESSION["email"] ?>">

                        <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                            <label for="old-psw" class="form-label">Vecchia password</label>
                            <input type="password" class="form-control" id="old-psw" required>
                            <div class="invalid-feedback">
                                Vechhia password errata!
                            </div>
                        </div>
                        <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                            <label for="new-psw" class="form-label">Nuova password</label>
                            <input type="password" class="form-control" id="new-psw" required>
                            <div class="invalid-feedback">
                                Controlla la tua password!
                            </div>
                        </div>

                        <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                            <label for="confirm-new-psw" class="form-label">Conferma nuova password</label>
                            <input type="password" class="form-control" id="confirm-new-psw" required>
                            <div class="invalid-feedback">
                                Le password non corrispondono!
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    <button type="button" class="btn btn-primary" id="psw-edit-apply">Applica</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector("#delete-user-button").onclick = function() {
            if (!confirm("Sei sicuro di voler eliminare il tuo profilo?")) {
                return;
            }

            const formData = new FormData();
            formData.append("email", this.getAttribute("data-user-email"));

            const url = "delete_profile.php";

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(responseText => {
                    if (responseText === "deleteProfileSuccess") {
                        location.replace("/");
                    } else {
                        document.querySelector("#delete-profile-error").classList.replace("d-none", "d-block");
                    }
                })
                .catch(error => {
                    document.querySelector("#delete-profile-error").classList.replace("d-none", "d-block");
                });

        }


        document.querySelector("#user-edit-apply").onclick = function() {

            let form = document.querySelector("#form-user");

            let name = form.querySelector("#user-name");
            let surname = form.querySelector("#user-surname");
            let errorUpdateProfile = form.querySelector("#edit-profile-error");

            name.classList.remove("is-invalid");
            surname.classList.remove("is-invalid");
            errorUpdateProfile.classList.replace("d-block", "d-none");

            let formData = new FormData();
            formData.append("email", form.querySelector("#user-email").value);
            formData.append("firstname", name.value);
            formData.append("lastname", surname.value);

            const url = "update_profile.php";

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(responseText => {
                    if (responseText === "updateProfileSuccess") {
                        location.reload();
                    } else {
                        if (responseText === "nameError") {
                            name.classList.add("is-invalid");
                        }
                        if (responseText === "surnameError") {
                            surname.classList.add("is-invalid");
                        }
                        if (responseText === "updateProfileError") {
                            errorUpdateProfile.classList.replace("d-none", "d-block");
                        }
                    }
                })
                .catch(error => {
                    errorUpdateProfile.classList.replace("d-none", "d-block");
                });

        }


        var formUser = document.getElementById('form-user');

        formUser.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;

            var userForm = formUser.querySelector('#user-form');

            userForm.querySelector('#user-email').value = button.getAttribute('data-bs-email');
            userForm.querySelector('#user-name').value = button.getAttribute('data-bs-name');
            userForm.querySelector('#user-surname').value = button.getAttribute('data-bs-surname');

        })


        document.querySelector("#psw-edit-apply").onclick = function() {

            let form = document.querySelector("#form-psw");
            let oldPsw = form.querySelector("#old-psw");
            let newPsw = form.querySelector("#new-psw");
            let confirmNewPsw = form.querySelector("#confirm-new-psw");
            let errorPsw = form.querySelector("#edit-psw-error");

            oldPsw.classList.remove("is-invalid");
            newPsw.classList.remove("is-invalid");
            confirmNewPsw.classList.remove("is-invalid");
            errorPsw.classList.replace("d-block", "d-none");

            let formData = new FormData();
            formData.append("email", form.querySelector("#psw-email").value);
            formData.append("oldpass", oldPsw.value);
            formData.append("newpass", newPsw.value);
            formData.append("newconfirm", confirmNewPsw.value);

            const url = "update_password.php";

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => response.text())
                .then(responseText => {
                    if (responseText === "updatePasswordSuccess") {
                        location.reload();
                    } else {
                        if (responseText === "oldPasswordError") {
                            oldPsw.classList.add("is-invalid");
                        }
                        if (responseText === "passwordError") {
                            newPsw.classList.add("is-invalid");
                        }
                        if (responseText === "confirmError") {
                            confirmNewPsw.classList.add("is-invalid");
                        }
                        if (responseText === "updatePasswordError") {
                            errorPsw.classList.replace("d-none", "d-block");
                        }
                    }
                })
                .catch(error => {
                    errorPsw.classList.replace("d-none", "d-block");
                });

        }


        var reservation = document.getElementsByClassName("delete-reservation-button");
        for (let i = 0; i < reservation.length; i++) {
            reservation[i].onclick =
                function() {
                    if (!confirm("Sei sicuro di voler eliminare la prenotazione?")) {
                        return;
                    }

                    const formData = new FormData();
                    formData.append("mode", "delete-booking");
                    formData.append("email", this.getAttribute("data-delete-email"));
                    formData.append("apartment", this.getAttribute("data-delete-apartment"));
                    formData.append("start", this.getAttribute("data-delete-start"));
                    formData.append("end", this.getAttribute("data-delete-end"));

                    const url = "delete_reservation.php";

                    fetch(url, {
                            method: "POST",
                            body: formData
                        })
                        .then(response => response.text())
                        .then(responseText => {
                            if (responseText == "deleteReservationSuccess") {
                                location.reload();
                            } else {
                                alert("Errore nell'eliminazione: " + responseText);
                            }
                        })
                        .catch(error => {
                            alert("Errore nell'eliminazione: " + error);
                        });

                }
        }
    </script>

    <?php
    include "res/php/footer.php";
    ?>


</body>

</html>