<?php
/*
 * Auteurs: Maël Gétain, Eliott Deriaz, Néo Masson, Theo Orlando
 * Date: 29.11.2022
 * Description: page d'information sur le sit
 * Copyright (c) 2022 ETML
 */
$_SESSION["verification"] = 0;
?>
<!--Text d'explication de l'existence du site -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<div class="w-50  mb-5 mx-auto">
    <h1>Pourquoi ce site existe</h1>
    <p>Ce site s'affiche sous vos yeux grâce à l'équipe de développement que je remercie chaleureusement.
        Sans eux rien n'aurait été possible.</p>
    <p>Ce site est née dû à la nécessité de faire un site pour gérer les idées des élèves</p>
</div>

<div class="d-flex justify-content-center">
    <canvas id="chart" style="width:600px !important;height:150px !important;"></canvas>
</div>