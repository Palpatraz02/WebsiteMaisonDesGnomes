<div class="row mt-5">

    <div class="col">

        <h2 class="text-center">La struttura</h2>

    </div>

</div>





<?php





$sql = "SELECT * FROM images WHERE objective = 'slideshow'";

$risultato = $conn->query($sql);

if ($risultato->num_rows > 0) {



?>





    <div class="row">

        <div class="col">
            <div id="carouselStruttura" class="carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselStruttura" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <?php

                    for ($i = 1; $i < $risultato->num_rows; $i++) {

                    ?>
                        <button type="button" data-bs-target="#carouselStruttura" data-bs-slide-to="<?php echo $i; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
                    <?php
                    }
                    ?>
                </div>
                <div class="carousel-inner">


                    <?php



                    for ($i = 0; $row = $risultato->fetch_assoc(); $i++) {

                        $src = $row["src"];

                        $titolo = $row["titolo"];

                        $desc = $row["descr"];



                        if ($i == 0) {

                            echo "<div class='carousel-item active'>";
                        } else

                            echo "<div class='carousel-item'>";

                    ?>

                        <img src="<?php echo $img_path . $src; ?>" class="d-block w-100" alt="<?php echo $titolo; ?>" />

                        <div class="carousel-caption d-none d-md-block bg-dark rounded">

                            <h5><?php echo $titolo; ?></h5>

                            <p class="text-cenetr"><?php echo $desc; ?></p>

                        </div>
                </div>
            <?php

                    }

            ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselStruttura" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselStruttura" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


    </div>

    </div>

<?php

}

?>



<div class="row">

    <div class="col mt-5">

        <p class="some-text text-center font-italic"><a href="struttura"><u>Per ulteriori informazioni sulla struttura cliccare qui</u></a></p>

    </div>

</div>