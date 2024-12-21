<div class="row mt-5">

    <div class="col">

        <h2 class="text-center">Gli appartamenti</h2>

    </div>

</div>

<div class="row">

    <div class="col">

        <p class="some-text">

            Tutti gli appartamenti sono provvisti di riscaldamento autonomo, cucina, lavatrice, forno, forno a microonde, wifi, smart tv, parcheggio privato ed ampio giardino in comune.

        </p>

    </div>

</div>

<?php
$img_path = "res/img/copertine/";
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

                        <a href="appartamenti?app=<?php echo $row["id"] ?>" class="btn btn-primary">Dettagli</a>

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