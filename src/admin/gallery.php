<a class="btn btn-primary btn-circle position-fixed bottom-0 end-0 m-5 z-1" data-bs-toggle="modal" data-bs-target="#form-img" data-bs-mode="add" data-bs-apartment="<?php echo $app_attuale; ?>" data-bs-objective="<?php echo $objective; ?>"><span class='material-icons-round text-white'>add</span>

</a>

<div class="col mt-4 mb-5">

    <div class="gallery">

        <?php

        $app = $app_attuale;
        $sql = $conn->prepare("SELECT * FROM images WHERE (app_id = ? or app_id IS NULL) AND objective = ?");
        $sql->bind_param('is', $app, $objective);


        if ($sql->execute() === TRUE) {
            $ris = $sql->get_result();

            if ($ris->num_rows > 0) {

                while ($row = $ris->fetch_assoc()) {

                    $img_src = $row["src"];

                    $img_title = $row["titolo"];

                    $img_descr = $row["descr"];
        ?>


                    <div class="img-wrap">

                        <div class="button">

                            <div class="action-buttons" style="display: none;">

                                <a class="btn btn-danger button-delete btn-square" data-img-id="<?php echo $row["id_img"]; ?>" data-img-src="<?php echo $img_src ?>"><span class='material-icons-round text-white'>delete</span>

                                </a>

                                <a class="btn btn-warning button-edit btn-square" data-bs-toggle="modal" data-bs-target="#form-img" data-bs-mode="edit" data-bs-title="<?php echo $img_title; ?>" data-bs-descr="<?php echo $img_descr; ?>" data-bs-src="<?php echo  $img_path . $img_src ?>" data-bs-id="<?php echo $row["id_img"]; ?>" data-bs-apartment="<?php echo $app_attuale; ?>" data-bs-objective="<?php echo $objective; ?>"><span class='material-icons-round text-white'>edit</span>

                                </a>

                            </div>



                            <a href="<?php echo $img_path . $img_src; ?>" class="img-box">

                                <img src="<?php echo $img_path . $img_src; ?>" class="w-100 shadow-1-strong rounded" alt="<?php echo $img_title; ?>" title="<?php echo $img_title; ?>" />

                            </a>

                        </div>

                    </div>

        <?php
                }
            }
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










<div class="modal fade" id="form-img" tabindex="-1" aria-labelledby="title-form-img" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-form-img"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post" enctype="multipart/form-data" id="img-form">



                    <input type="hidden" name="img-id" id="img-id" value="">
                    <input type="hidden" name="img-apartment" id="img-apartment" value="">
                    <input type="hidden" name="img-objective" id="img-objective" value="">

                    <input type="hidden" name="mode" id="mode" value="">



                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="img-title" class="form-label">Titolo</label>
                        <input type="text" class="form-control" id="img-title" name="img-title" required>
                    </div>
                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="img-descr" class="form-label">Descrizione</label>
                        <textarea type="text" class="form-control" id="img-descr" name="img-descr"></textarea>
                    </div>

                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center" id="img-src-box">

                        <label for="img-src" class="form-label">Immagine</label>

                        <input type="file" class="form-control" id="img-src" name="img-src" required>
                        <img src="" id="img-preview" class="w-100 shadow-1-strong rounded" alt="Immagine" title="Immagine" style="display: none;" />

                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" id="img-apply">Applica</button>
            </div>
        </div>
    </div>
</div>

<script>
    var formImg = document.getElementById('form-img');

    formImg.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget;
        // Extract info from data-bs-* attributes
        var mode = button.getAttribute('data-bs-mode');
        var imgForm = formImg.querySelector('#img-form'); // Form da lasciare?

        var imgApartment = formImg.querySelector('#img-apartment');
        var imgObjective = formImg.querySelector('#img-objective');
        var imgMode = formImg.querySelector('#mode');

        imgApartment.value = button.getAttribute('data-bs-apartment');
        imgObjective.value = button.getAttribute('data-bs-objective');
        imgMode.value = mode;

        if (mode == "edit") {
            var title = button.getAttribute('data-bs-title');
            var descr = button.getAttribute('data-bs-descr');
            var src = button.getAttribute('data-bs-src');
            var id = button.getAttribute('data-bs-id');



            var modalTitle = formImg.querySelector('.modal-title');
            modalTitle.textContent = 'Modifica immagine';

            var modalImgTitle = formImg.querySelector('#img-title');
            var modalImgDescr = formImg.querySelector('#img-descr');



            var modalImgSrc = formImg.querySelector('#img-src');
            var modalImgPreview = formImg.querySelector('#img-preview');

            modalImgTitle.value = title;
            modalImgDescr.value = descr;
            modalImgSrc.removeAttribute("required");
            modalImgSrc.style.display = "none";

            modalImgPreview.src = src;
            modalImgPreview.style.display = "block";
            modalImgPreview.title = title;
            modalImgPreview.alt = title;

            var modalImgId = formImg.querySelector('#img-id');
            modalImgId.value = id;

        } else if (mode == "add") {

            var modalTitle = formImg.querySelector('.modal-title');
            modalTitle.textContent = 'Aggiungi immagine';

            var modalImgTitle = formImg.querySelector('#img-title');
            var modalImgDescr = formImg.querySelector('#img-descr');

            var modalImgSrc = formImg.querySelector('#img-src');
            var modalImgPreview = formImg.querySelector('#img-preview');

            modalImgTitle.value = "";
            modalImgDescr.value = "";
            modalImgSrc.setAttribute("required", "");
            modalImgSrc.style.display = "block";
            modalImgSrc.value = "";
            modalImgPreview.src = "";
            modalImgPreview.style.display = "none";
        }
    })



    var images = document.getElementsByClassName("img-wrap");
    for (let i = 0; i < images.length; i++) {
        images[i].onmouseover = function() {
            images[i].querySelector(".action-buttons").style.display = "block";
        }
        images[i].onmouseleave = function() {
            images[i].querySelector(".action-buttons").style.display = "none";
        }
        images[i].querySelector(".action-buttons .button-delete").onclick = function() {
            if (!confirm("Sei sicuro di voler eliminare l'immagine?")) {
                return;
            }

            var formData = new FormData();
            formData.append("mode", "delete");
            formData.append("id", this.getAttribute("data-img-id"));
            formData.append("src", this.getAttribute("data-img-src"));

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
                    alert("Errore nell'eliminazione :" + error.message);
                });

        }
    }

    document.querySelector("#img-apply").onclick = function() {

        var form = document.querySelector("#img-form");

        var formData = new FormData();
        formData.append("mode", form.querySelector("#mode").value);
        formData.append("id", form.querySelector("#img-id").value);
        formData.append("objective", form.querySelector("#img-objective").value);
        formData.append("apartment", parseInt(form.querySelector("#img-apartment").value));
        formData.append("title", form.querySelector("#img-title").value);
        formData.append("descr", form.querySelector("#img-descr").value);
        formData.append("src", form.querySelector("#img-src").files[0]);

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
</script>