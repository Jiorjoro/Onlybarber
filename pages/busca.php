<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/busca.css">
    <link rel="stylesheet" href="../css/feeds.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <script src="../js/feedFunctions.js"></script>
    <title>Em Alta | Onlybarber</title>
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
    <form class='search' action="busca.php" method="post">
        <select name="scope">
            <option value="user">Pessoas</option>
            <option value="tag">Tags</option>
            <option value="content">Conteúdo</option>
        </select>
        <input type="search" placeholder="Pesquisar" name="search">
        <input type="submit" value="Buscar">
    </form>

    <div class="feedTray">
        <?php
            
            if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'){
                if(!empty($_POST['search'])){
                    require "../php/functions.php";
                    $search = $_SESSION['search'] = qBoa($_POST['search']);
                    $scope =  $_SESSION['scope'] = $_POST['scope'];
                }            
            }
            if(!empty($_SESSION['search'])){
                $search = $_SESSION['search'];
                $scope =  $_SESSION['scope'];

                if($scope == 'tag' || $scope == 'content'){
                    echo "<script>loadFeed('search');</script>";
                } elseif($scope == 'user'){
                    require "../php/dbconn.php";

                    $sqlProf = $conn->prepare("SELECT userId AS profUserId, userName AS profUserName, userPicture AS profUserPic 
                    FROM logins WHERE userName LIKE CONCAT('%', ?, '%')");
                    $sqlProf->bind_param('s', $search);
                    $sqlProf->execute();
                    $resultProf = $sqlProf->get_result();
                    $sqlProf->close();

                    if($resultProf->num_rows > 0){
                        while($rowP = $resultProf->fetch_assoc()){
                            $profUserId = $rowP['profUserId'];
                            $profUserName = $rowP['profUserName'];
                            $profUserPic = $rowP['profUserPic'];

                            include "../templates/prof-search.php";
                        }
                    } else {
                        echo "<h2>Nenhum Perfil Encontrado</h2>";
                    }


                }
            }
        ?>

    </div>
</body>
<script src="../js/userFunctions.js"></script>
<script>
    // eventos
    window.addEventListener("scroll", function(){loadFeed('search');});
</script>
</html>