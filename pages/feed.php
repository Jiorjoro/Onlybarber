<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/feeds.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Feed | Onlybarber</title>
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

    
        echo '<form class="creatPost" action="../php/creatpost.php" method="post" enctype="multipart/form-data">
            <textarea name="postTxt" max-length="200" placeholder="O que está pensando?"></textarea>
            <div class="erro">
                ';
                    if(isset($_SESSION["uploadErr"])){
                        echo $_SESSION["uploadErr"];
                    }
            
        echo    '</div>
            <input type="hidden" name="MAX_FILE_SIZE" value="50000000" />
            <div>
                <label for="postUpload">
                    <i class="feather-paperclip"></i>Escolha um arquivo
                </label>
                <input type="file" name="postUpload" id="postUpload" accept="image/*, video/*">
                <input type="submit" name="submit" value="Postar">
            </div>
        </form>';
        }
    ?>
    <div class="feedTray">

    </div>
</body>
<script src="../js/feedFunctions.js"></script>
<script src="../js/userFunctions.js"></script>
<script>
    // eventos
    loadFeed('follow');
    window.addEventListener("scroll", function(){loadFeed('follow');});
</script>
</html>