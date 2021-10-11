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
    <title>Postagem | Onlybarber</title>
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
            
            $userId = $_SESSION['userId'];
        } else {
            $userId = 0;
        }
    ?>
    <div class="feedTray">
        <?php

            require "../php/functions.php";
            require "../php/dbconn.php";

            $postId = qBoa($_GET['postId']);

            $sql = $conn->prepare("SELECT * FROM donePost WHERE postId=? LIMIT 1");
            $sql->bind_param('i', $postId);
            $sql->execute();
            $result = $sql->get_result();

            if($result->num_rows > 0){
                $posts = "";
                require "../php/loadPosts.php";

                echo $posts;
            } else {
                echo "<h2>Nenhuma Postagem Encontrada</h2>";
            }
        ?>
    </div>
</body>
<script src="../js/feedFunctions.js"></script>
<script src="../js/userFunctions.js"></script>
</html>