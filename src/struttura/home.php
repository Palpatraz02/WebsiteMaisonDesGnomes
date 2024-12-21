<div class="container mt-5">

    <div class="row">

        <div class="col mt-5">



            <h1 class="text-center">La struttura</h1>



        </div>

    </div>



    <div class="row">

        <div class="col pt-2" style="background-color: rgba(219,200,26,0.12); border-radius: 10px">



            <p class="some-text">La casa vacanze si trova nella tranquilla frazione di Maé (1100 mt. di altitudine) a

                Challand-Saint-Anselme nella Val d'Ayas, è situata nel centro storico in un’abitazione ristrutturata del

                1905 circondata da un’ampia zona verde privata ed è composta da 5 appartamenti. Il capoluogo, dove si

                possono trovare tutti i servizi, dista 1,5 km, raggiungibile anche a piedi in 20 min. lungo una

                passeggiata immersi nella natura. Comoda fermata autobus a 2 min. La frazione dista 5 Km da Brusson, 11

                Km dalle piste da sci di Palasinaz, 16 Km da Champoluc. In 18 min si raggiunge l'autostrada e il fondo

                valle dov'é possibile visitare castelli medioevali. Per chi ama la natura e il relax &egrave; possibile

                accedere a numerosi itinerari da percorrere a piedi o in bicicletta.<br>

                Mettiamo a disposizione dei clienti un ampio giardino in comune dotato di: tavoli, sedie, ombrelloni,

                sdraio e barbecue. Inoltre la struttura è dotata di un parcheggio privato. <br>Tutti gli appartamenti

                sono provvisti di riscaldamento autonomo, cucina, lavatrice, forno, forno a microonde, wifi, smart tv,

                lenzuola, asciugamani, sapone e doccia-shampoo.</p>



            <p><b>Nota:</b> gli appartamenti si affittano a partire da un minimo di due notti.</p>

        </div>

    </div>



    <hr class='my-5'>



    <div class="row">

        <div class="col">

            <h2 class="text-center">Galleria</h2>

        </div>

    </div>



    <div class="gallery mt-4 mb-5">

        <?php





        $sql = "SELECT * FROM images WHERE objective = 'structure'";

        $risultato = $conn->query($sql);





        if ($risultato->num_rows > 0) {

            while ($row = $risultato->fetch_assoc()) {

                $src = $row["src"];

                $titolo = $row["titolo"];

                ?>

                <div class="img-wrap">

                    <div class="button">



                        <a href="<?php echo $img_path . $src; ?>" class="img-box">



                            <img

                                    src="<?php echo $img_path . $src; ?>"

                                    class="w-100 shadow-1-strong rounded"

                                    alt="<?php echo $titolo; ?>"

                                    title="<?php echo $titolo; ?>"

                            />

                        </a>

                    </div>

                </div>

                <?php

            }

        }



        ?>





    </div>



</div>





<script src="../res/js/simple-lightbox.js?v2.8.0"></script>





<script>

    (function () {

        var $gallery = new SimpleLightbox('.img-box', {



            navText: ["<span class='material-icons-round' style='color:white;'>arrow_back</span>", "<span class='material-icons-round' style='color:white;'>arrow_forward</span>"],

            closeText: "<span class='material-icons-round' style='color:white;'>close</span>",

            captions: false,

            alertErrorMessage: 'Immagine non trovata',

            showCounter: false,



        });

    })();

</script>



