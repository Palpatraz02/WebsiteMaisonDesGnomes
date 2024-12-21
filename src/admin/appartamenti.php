<div class="container mt-5">

    <div class="row">

        <div class="col mt-5">



            <h1 class="text-center">Appartamenti</h1>



        </div>

    </div>
    <div class="row">
        <div class="col pt-2 mb-3">
            <div class="d-flex flex-row form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" id="searchText" type="search" placeholder="Cerca" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0 ms-2" id="searchButton">Search</button>
            </div>

        </div>
    </div>
    <a class="btn btn-primary btn-circle position-fixed bottom-0 end-0 m-5 z-1" data-bs-toggle="modal" data-bs-target="#form-apartment"><span class='material-icons-round text-white'>add</span></a>
    <div id="apartments">
        <?php

        $img_path = "../res/img/copertine/";



        $sql = $conn->prepare("SELECT * FROM apartments");

        if ($sql->execute() === TRUE) {
            $ris = $sql->get_result();

            if ($ris->num_rows > 0) {
                echo "<div class=\"row d-flex justify-content-center\">";
                while ($row = $ris->fetch_assoc()) {

        ?>
                    <div class="col-md-4 mt-3 mb-3">

                        <div class="card card-animation">

                            <img src="<?php echo $img_path . $row["tumbnail"] ?>" class="card-img-top" alt="..." />

                            <div class="card-body">

                                <h5 class="card-title"><?php echo $row["title"] ?></h5>

                                <p class="card-text some-text">

                                    <?php echo $row["short_descr"] ?>

                                </p>
                                <div class="d-flex justify-content-between buttons">
                                    <a class="btn btn-danger btn-square delete-apartment-button button" data-apartment-id="<?php echo $row["id"]; ?>" data-tumbnail-src="<?php echo $row["tumbnail"]; ?>"><span class='material-icons-round text-white'>delete</span> </a>

                                    <a class="btn btn-warning btn-square button" href="/admin?cat=3&app=<?php echo $row['id']; ?>"><span class='material-icons-round text-white'>edit</span></a>
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
</div>




<div class="modal fade" id="form-apartment" tabindex="-1" aria-labelledby="title-form-apartment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-form-apartment">Aggiungi appartamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post" enctype="multipart/form-data" id="apartment-form">


                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="apartment-title" class="form-label">Titolo</label>
                        <input type="text" class="form-control" id="apartment-title" name="apartment-title" required>
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="apartment-descr" class="form-label">Descrizione completa</label>
                        <textarea type="text" class="form-control" id="apartment-descr" name="apartment-descr"></textarea>
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="apartment-descr-short" class="form-label">Descrizione breve</label>
                        <textarea type="text" class="form-control" id="apartment-descr-short" name="apartment-descr-short"></textarea>
                    </div>

                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center" id="tumbnail-src-box">

                        <label for="tumbnail-src" class="form-label">Copertina</label>

                        <input type="file" class="form-control" id="tumbnail-src" name="tumbnail-src" required>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" id="apartment-add-apply">Applica</button>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = loadFunctions;

    function loadFunctions() {
        var images = document.getElementsByClassName("buttons");
        for (let i = 0; i < images.length; i++) {
            images[i].querySelector(".delete-apartment-button").onclick = function() {
                if (!confirm("Sei sicuro di voler eliminare l'appartamento?")) {
                    return;
                }

                var formData = new FormData();
                formData.append("mode", "delete-apartment");
                formData.append("id", this.getAttribute("data-apartment-id"));
                formData.append("src", this.getAttribute("data-tumbnail-src"));

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
    }


    document.querySelector("#apartment-add-apply").onclick = function() {

        var form = document.querySelector("#apartment-form");

        var formData = new FormData();
        formData.append("mode", "add-apartment");
        formData.append("title", form.querySelector("#apartment-title").value);
        formData.append("descr", form.querySelector("#apartment-descr").value);
        formData.append("shortdescr", form.querySelector("#apartment-descr-short").value);
        formData.append("src", form.querySelector("#tumbnail-src").files[0]);

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
                        alert("Errore nell'aggiunta (" + response.status + "): " + text);
                    }
                })
            })
            .catch(error => {
                alert("Errore nell'aggiunta: " + error.message);
            });


    }

    document.querySelector("#searchButton").onclick = function() {
        var search = document.querySelector("#searchText").value;
        var formData = new FormData();
        formData.append("search", search);
        const url = "cerca_appartamenti.php";

        fetch(url, {
                method: "POST",
                body: formData
            })
            .then(response => {
                response.text().then(text => {
                    if (response.status === 200) {
                        document.querySelector("#apartments").innerHTML = text;
                        loadFunctions();
                    } else {
                        alert("Errore nella ricerca (" + response.status + "): " + text);
                    }
                })
            })
            .catch(error => {
                alert("Errore nella ricerca: ", error.message);
            });

    }
</script>