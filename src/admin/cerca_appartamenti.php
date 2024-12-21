<?php
http_response_code(500);
session_start();
if (!isset($_SESSION["admin"])) {

    die("Non sei loggato");
}

if ($_SESSION["admin"] != true) {

    die("Non sei admin");
}


include "../res/php/db_conn.php";

$img_path = "../res/img/copertine/";

$search = "%" . $_REQUEST["search"] . "%";

$sql = $conn->prepare("SELECT * FROM apartments WHERE title LIKE ? OR short_descr LIKE ?");
$sql->bind_param('ss', $search, $search);

if ($sql->execute() === TRUE) {
    $ris = $sql->get_result();
    http_response_code(200);
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