<nav class="navbar navbar-expand-lg bg-body-tertiary bg-light navbar-light fixed-top z-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="/~S5146769"><img src="/~S5146769/res/img/altro/logo.png" height="50px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/~S5146769">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~S5146769/struttura">Struttura</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Appartamenti
                    </a>
                    <ul class="dropdown-menu">
                        <?php

                        $sql = $conn->prepare("SELECT * FROM apartments");

                        if ($sql->execute() === TRUE) {

                            $ris = $sql->get_result();
                            while ($row = $ris->fetch_assoc()) {
                                echo "<li><a class='dropdown-item' href='/~S5146769/appartamenti/?app=" . $row['id'] . "'>" . $row['title'] . "</a></li>";
                            }
                        } else {
                            die("Errore appartamento non trovato");
                        }
                        $sql->close();



                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/~S5146769/prenotazioni">Prenota</a>
                </li>
            </ul>
            <div class="d-flex">
                <ul class="navbar-nav d-flex flex-row me-1">

                    <li class="nav-item me-3 me-lg-0">

                        <a class="nav-link" href="tel:+393495558814"><span class="material-icons-round">call</span></a>

                    </li>

                    <li class="nav-item me-3 me-lg-0">

                        <a class="nav-link" href="mailto:chanty79@hotmail.it"><span class="material-icons-round">email</span></a>

                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <?php
                        if (isset($_SESSION["admin"]) and $_SESSION["admin"] == true) {
                            echo "<a class='nav-link' href='/~S5146769/admin'><span class='material-icons-round'>admin_panel_settings</span></a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <?php
                        if (isset($_SESSION["logged"])) {
                            echo "<a class='nav-link' href='/~S5146769/show_profile.php'><span class='material-icons-round'>account_circle</span></a>";
                        }
                        ?>
                    </li>
                    <li class="nav-item me-3 me-lg-0">
                        <?php
                        if (isset($_SESSION["logged"])) {
                            echo "<a class='nav-link' href='/~S5146769/logout.php'><span class='material-icons-round text-danger'>logout</span></a>";
                        } else {
                            echo "<a class='nav-link btn' data-bs-toggle='modal' data-bs-target='#form-login'><span class='material-icons-round text-success'>login</span></a>";
                        }
                        ?>


                    </li>

                </ul>
            </div>
        </div>
    </div>
</nav>

<?php
include "form_login.php";
?>