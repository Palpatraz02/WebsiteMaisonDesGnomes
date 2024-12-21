<div class="container mt-5">

    <div class="row">

        <div class="col mt-5">

            <h1 class="text-center">Lista prenotazioni</h1>

        </div>

    </div>
    <div class="row">

        <div class="col mt-5 justify-content-end d-flex">

            <button type="button" class="btn btn-info p-2" id="past_booking">Prenotazioni passate</button>

        </div>
        <div class="col-md-auto mt-5 d-flex">

            <button type="button" class="btn btn-info p-2" id="all_bookings">Tutte le prenotazioni</button>

        </div>
        <div class="col mt-5 ">

            <button type="button" class="btn btn-info p-2" id="future_booking">Prenotazioni future</button>

        </div>

    </div>
    <div id="reservation">
        <?php

        $sql = $conn->prepare("SELECT bookings.email, apartment, start_date, end_date, title, name, surname FROM bookings JOIN users ON bookings.email = users.email JOIN apartments ON apartments.id = bookings.apartment ORDER BY start_date ");

        if ($sql->execute() === TRUE) {
            $ris = $sql->get_result();

            if ($ris->num_rows > 0) {
                echo "<div class=\"row d-flex justify-content-center\">";
                while ($row = $ris->fetch_assoc()) {
        ?>
                    <div class="col-md-6 mt-3 mb-3">

                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">

                                    <h5 class="card-title"><?php echo $row["email"] ?></h5>

                                </div>


                                <p class="card-text some-text">
                                    Nome: <?php echo $row["name"] ?><br>
                                    Cognome: <?php echo $row["surname"] ?> <br>
                                    Appartamento prenotato: <?php echo $row["title"] ?> <br>
                                    Dal: <?php echo date("d/m/Y", strtotime($row["start_date"])) ?> <br>
                                    Al: <?php echo date("d/m/Y", strtotime($row["end_date"])) ?> <br>
                                </p>
                                <div class="d-flex justify-content-between buttons">
                                    <a class="btn btn-danger btn-square delete-reservation-button button" data-delete-email="<?php echo $row["email"]; ?>" data-delete-apartment="<?php echo $row["apartment"]; ?>" data-delete-start="<?php echo $row["start_date"] ?>" data-delete-end="<?php echo $row["end_date"] ?>">
                                        <span class='material-icons-round text-white'>delete</span></a>

                                </div>


                            </div>

                        </div>

                    </div>
        <?php
                }
                echo "</div>";
            }
        } else {

            die("Errore prenotazione non trovato");
        }

        $sql->close();
        ?>
    </div>
</div>


<script defer>
    window.onload = loadFunctions;

    function loadFunctions() {
        var reservations = document.getElementsByClassName("buttons");
        for (let i = 0; i < reservations.length; i++) {
            reservations[i].querySelector(".delete-reservation-button").onclick = function() {
                if (!confirm("Sei sicuro di voler eliminare la prenotazione?")) {
                    return;
                }

                const formData = new FormData();
                formData.append("mode", "delete-booking");
                formData.append("email", this.getAttribute("data-delete-email"));
                formData.append("apartment", this.getAttribute("data-delete-apartment"));
                formData.append("start", this.getAttribute("data-delete-start"));
                formData.append("end", this.getAttribute("data-delete-end"));
                const url = "gestione.php";

                fetch(url, {
                        method: "POST",
                        body: formData
                    })
                    .then(response => {
                        response.text().then(text => {
                            if (response.status === 201) {
                                location.reload();
                            } else {
                                alert("Errore nell'eliminazione (" + response.status + "): " + text);
                            }
                        })
                    })
                    .catch(error => {
                        alert("Errore nell'eliminazione " + error.message);
                    });

            }
        }


        document.querySelector("#past_booking").onclick = function() {
            var formData = new FormData();
            formData.append("type", "old_bookings");
            const url = "tipi_prenotazione.php";

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    response.text().then(text => {
                        if (response.status === 200) {
                            document.querySelector("#reservation").innerHTML = text;
                            loadFunctions();
                        } else {
                            alert("Errore old bookings (" + response.status + "): " + text);
                        }
                    })
                })
                .catch(error => {
                    alert("Errore old bookings: " + error.message);
                });

        }
        document.querySelector("#future_booking").onclick = function() {
            var formData = new FormData();
            formData.append("type", "new_bookings");
            const url = "tipi_prenotazione.php";

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    response.text().then(text => {
                        if (response.status === 200) {
                            document.querySelector("#reservation").innerHTML = text;
                            loadFunctions();
                        } else {
                            alert("Errore new bookings (" + response.status + "): " + text);
                        }
                    })
                })
                .catch(error => {
                    alert("Errore new bookings: " + error.message);
                });

        }
        document.querySelector("#all_bookings").onclick = function() {
            const formData = new FormData();
            formData.append("type", "all_bookings");
            const url = "tipi_prenotazione.php";

            fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    response.text().then(text => {
                        if (response.status === 200) {
                            document.querySelector("#reservation").innerHTML = text;
                            loadFunctions();
                        } else {
                            alert("Errore all bookings (" + response.status + "): " + text);
                        }
                    })
                })
                .catch(error => {
                    alert("Errore all bookings: " + error.message);
                });
        }
    }
</script>