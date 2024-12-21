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


$type = $_REQUEST["type"];
switch ($type) {
    case "old_bookings":
        $sql = $conn->prepare("SELECT bookings.email, apartment, start_date, end_date, title, name, surname FROM bookings
                                JOIN users ON bookings.email = users.email JOIN apartments ON apartments.id = bookings.apartment
                                WHERE start_date < CURDATE() ORDER BY start_date ");
        break;
    case "new_bookings":
        $sql = $conn->prepare("SELECT bookings.email, apartment, start_date, end_date, title, name, surname FROM bookings
                                JOIN users ON bookings.email = users.email JOIN apartments ON apartments.id = bookings.apartment
                                WHERE start_date > CURDATE() ORDER BY start_date ");
        break;
    default: //all bookings included
        $sql = $conn->prepare("SELECT bookings.email, apartment, start_date, end_date, title, name, surname FROM bookings 
                                    JOIN users ON bookings.email = users.email JOIN apartments ON apartments.id = bookings.apartment 
                                    ORDER BY start_date ");
        break;
}


if ($sql->execute() === TRUE) {
    $ris = $sql->get_result();
    http_response_code(200);
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

    die("Errore appartamento non trovato");
}

$sql->close();
?>