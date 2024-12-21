<?php
//phpinfo();
//$cat = 3;

//$ind = 3;

//aggiungere controllo e sanitizazione numero appartamenti
$objective = "apartment";

$title = "";
$descr = "";
$shortdescr = "";
$src = "";

$sql = $conn->prepare("SELECT * FROM apartments WHERE id = ?");


$sql->bind_param('i', $app_attuale);

if ($sql->execute() === TRUE) {

    $ris = $sql->get_result();
    if ($ris->num_rows > 0) {
        $ris = $ris->fetch_assoc();
    } else {
        die("Errore appartamento non trovato");
    }


    $title = $ris["title"];
    $descr = $ris["descr"];
    $shortdescr = $ris["short_descr"];
    $src = "../res/img/copertine/" . $ris["tumbnail"];
} else {

    die("Errore appartamento non trovato");
}

$sql->close();



?>






<div class="container mt-5">

    <div class="row">

        <div class="col mt-5 d-flex justify-content-center">



            <h1 class="text-center"><?php echo $title; ?></h1>
            <a class="btn btn-warning btn-square button mx-2" data-bs-toggle="modal" data-bs-target="#form-apartment"><span class='material-icons-round text-white'>edit</span></a>



        </div>

    </div>


    <div class="row">

        <div class="col pt-2" style="background-color: rgba(219,200,26,0.12); border-radius: 10px">



            <p class="some-text"><?php echo $descr; ?></p>



        </div>

    </div>







    <div class="row">
        <?php include("gallery.php"); ?>
    </div>
</div>


<div class="modal fade" id="form-apartment" tabindex="-1" aria-labelledby="title-form-apartment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title-form-apartment">Modifica appartamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php" method="post" enctype="multipart/form-data" id="apartment-form">



                    <input type="hidden" name="apartment-id" id="apartment-id" value="<?php echo $app_attuale ?>">


                    <div class="mb-3 d-flex flex-column justify-content-center align-items-center">
                        <label for="apartment-title" class="form-label">Titolo</label>
                        <input type="text" class="form-control" id="apartment-title" name="apartment-title" value="<?php echo $title; ?>" required>
                    </div>
                    <div class="mb-3 d-flex flex-column justifapartmenty-content-center align-items-center">
                        <label for="apartment-descr" class="form-label">Descrizione completa</label>
                        <textarea type="text" class="form-control" id="apartment-descr" name="apartment-descr"><?php echo $descr; ?></textarea>
                    </div>
                    <div class="mb-3 d-flex flex-column justifapartmenty-content-center align-items-center">
                        <label for="apartment-descr-short" class="form-label">Descrizione breve</label>
                        <textarea type="text" class="form-control" id="apartment-descr-short" name="apartment-descr-short"><?php echo $shortdescr; ?></textarea>
                    </div>

                    <!--<div class="mb-3 d-flex flex-column justify-content-center align-items-center" id="tumbnail-src-box">

                        <label for="tumbnail-src" class="form-label">Copertina</label>

                        <input type="file" class="form-control" id="tumbnail-src" name="tumbnail-src">
                        <img src="<?php //echo $src; ?>" id="tumbnail-preview" class="w-100 shadow-1-strong rounded" alt="Copertina" title="Copertina" />

                    </div>-->


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                <button type="button" class="btn btn-primary" id="apartment-edit-apply">Applica</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector("#apartment-edit-apply").onclick = function() {

        var form = document.querySelector("#apartment-form");
        var formData = new FormData();
        formData.append("mode", "edit-apartment");
        formData.append("id", form.querySelector("#apartment-id").value);
        formData.append("title", form.querySelector("#apartment-title").value);
        formData.append("descr", form.querySelector("#apartment-descr").value);
        formData.append("shortdescr", form.querySelector("#apartment-descr-short").value);

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
                alert("Errore nell'inserimento: " + error);
            });


    }
</script>