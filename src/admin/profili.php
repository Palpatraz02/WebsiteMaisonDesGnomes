<div class="container mt-5">

    <div class="row">

        <div class="col mt-5">

            <h1 class="text-center">Profili utente</h1>

        </div>

    </div>

    <?php

    $sql = $conn->prepare("SELECT * FROM users ORDER BY admin DESC, email ASC");

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
                                <?php
                                if ($row["admin"] == 1) {
                                    echo "<h5 class='card-title text-success'>Admin</h5>";
                                }
                                ?>

                            </div>

                            <p class="card-text some-text">
                                Nome: <?php echo $row["name"] ?><br>
                                Cognome: <?php echo $row["surname"] ?> <br>
                            </p>
                            <div class="d-flex justify-content-between buttons">
                                <a class="btn btn-danger btn-square delete-user-button button" data-user-email="<?php echo $row["email"]; ?>"><span class='material-icons-round text-white'>delete</span></a>

                                <a class="btn btn-warning btn-square button" data-bs-toggle="modal" data-bs-target="#form-user" data-bs-email="<?php echo $row["email"]; ?>" data-bs-name="<?php echo $row["name"]; ?>" data-bs-surname="<?php echo $row["surname"]; ?>" data-bs-admin="<?php echo $row["admin"] ?>"><span class='material-icons-round text-white'>edit</span></a>
                            </div>


                        </div>

                    </div>

                </div>
    <?php
            }
            echo "</div>";
        }
    } else {

        die("Errore appartamento non trovato");
    }

    $sql->close();
    ?>
</div>




<div class="modal fade" id="form-user" tabindex="-1" aria-labelledby="title-form-user" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-form-user">Modifica profilo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" id="user-form">


                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="user-email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="user-email" name="user-email" disabled>
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="user-name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="user-name" name="user-name">
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="user-surname" class="form-label">Cognome</label>
                        <input type="text" class="form-control" id="user-surname" name="user-surname">
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="user-admin" name="user-admin" value="">
                            <label class="form-check-label" for="user-admin">
                                Admin
                            </label>
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

<script>
    var images = document.getElementsByClassName("buttons");
    for (let i = 0; i < images.length; i++) {
        images[i].querySelector(".delete-user-button").onclick = function() {
            if (!confirm("Sei sicuro di voler eliminare il profilo?")) {
                return;
            }

            const formData = new FormData();
            formData.append("mode", "delete-user");
            formData.append("email", this.getAttribute("data-user-email"));

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
                    alert("Errore nell'eliminazione: " + error.message);
                });

        }
    }


    document.querySelector("#user-edit-apply").onclick = function() {

        var form = document.querySelector("#form-user");

        var formData = new FormData();
        formData.append("mode", "edit-user");
        formData.append("email", form.querySelector("#user-email").value);
        formData.append("name", form.querySelector("#user-name").value);
        formData.append("surname", form.querySelector("#user-surname").value);
        formData.append("admin", form.querySelector("#user-admin").checked ? 1 : 0);

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
                        alert("Errore nell'inserimento (" + response.status + "): " + text);
                    }
                })
            })
            .catch(error => {
                alert("Errore nell'inserimento: " + error.message);
            });

    }

    var formUser = document.getElementById('form-user');

    formUser.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget;

        var userForm = formUser.querySelector('#user-form');

        userForm.querySelector('#user-email').value = button.getAttribute('data-bs-email');
        userForm.querySelector('#user-name').value = button.getAttribute('data-bs-name');
        userForm.querySelector('#user-surname').value = button.getAttribute('data-bs-surname');

        if (button.getAttribute('data-bs-admin') == 1) {
            userForm.querySelector('#user-admin').setAttribute('checked', 'checked');
        } else {
            userForm.querySelector('#user-admin').removeAttribute('checked');
        }

    })
</script>