<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/sponsors.css">
    <link rel="stylesheet" href="../css/feeds.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Patrocinadores | Onlybarber</title>
</head>
<body>
    <?php

        // inicia a sessão pro site
        session_start();

        // pega dados do cookie
        include "../php/getCookie.php";

        // cabeçalho
        include "../templates/cabecalho.php";

        // menu princupal
        include "../templates/main-menu.php";

        // div patrocinadores
        include "../templates/sponsors-panel.php";

        // tags mais usadas
        include "../templates/top-tags.php";

        // progaganda direita
        include "../templates/propaganda-princ.php";

        // caixinha de notificação
        if(isset($_SESSION['userId'])){
            include "../templates/notification.php";
        }
    ?>
    <div class="sponsorsTray">
        <div class="sponsor">
            <div class="sponsor-head">
                <img src="../media/usersPictures/defaultIcon.png" alt="Logo-Patrocinador">
                <div class="nome">
                    Sem patrocinadores ainda
                </div>
            </div>
            <div class="sponsor-bio">
                Se quiser divulgar sua barbearia e/ou seu trabalho é possivel virar um parceiro do Onlybarber.
                <br>
                Email: onlybarbersuporte@gmail.com
                Celular: 9 9924-2433
            </div>
        </div>
    </div>
</body>
<script src="../js/userFunctions.js"></script>
</html>