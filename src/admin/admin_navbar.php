<nav class="navbar navbar-expand-lg bg-body-tertiary bg-light navbar-light fixed-top z-2">
    <div class="container-fluid">
        <a class="navbar-brand" href="../"><img src="../res/img/altro/logo.png" height="50px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?cat=1">Struttura</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?cat=2">Appartamenti</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?cat=4">Profili</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?cat=5">Prenotazioni</a>
                </li>
            </ul>

            <div class="d-flex">
                <?php

                if (isset($_SESSION["email"])) {

                ?>

                    <ul class="navbar-nav d-flex flex-row me-1">

                        <li class="nav-item me-3 me-lg-0">

                            <a class="nav-link" href="../logout.php"><span class="material-icons-round text-danger">logout</span></a>

                        </li>

                    </ul>

                <?php

                }

                ?>
            </div>
        </div>
    </div>
</nav>