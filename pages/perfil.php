<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/perfil.css">
    <link rel="stylesheet" href="../css/feeds.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Perfil | Onlybarber</title>
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

        // caixinha de notificação
        if(isset($_SESSION['userId'])){
            include "../templates/notification.php";

            $userId = $_SESSION['userId'];
        } else {
            $userId = 0;
        }

        if(isset($_GET['pU'])){
            $_SESSION['profUserId'] = $_GET['pU'];
        }

        require "../php/dbconn.php";

        $getUser = $conn->prepare("SELECT userName, userPicture, userBio, userAccess FROM logins WHERE userId=?");
        $getUser->bind_param('i', $_SESSION['profUserId']);
        $getUser->execute();
        $userData = $getUser->get_result();
        $getUser->close();

        while($rowU = $userData->fetch_assoc()){
            $userName = $rowU['userName'];
            $userPicture = $rowU['userPicture'];
            $userBio = $rowU['userBio'];
            $userAccess = $rowU['userAccess'];
        }

        $getFollow = $conn->prepare("SELECT COUNT(followId) AS totFollow FROM follows WHERE followedId=?");
        $getFollow->bind_param('i', $_SESSION['profUserId']);
        $getFollow->execute();
        $followData = $getFollow->get_result();
        $getFollow->close();

        while($rowf = $followData->fetch_assoc()){
            $totFollow = $rowf['totFollow'];
        }

        $getFollow2 = $conn->prepare("SELECT followId FROM follows WHERE followedId=? AND followerId=?");
        $getFollow2->bind_param('ii', $_SESSION['profUserId'], $userId);
        $getFollow2->execute();
        $followData2 = $getFollow2->get_result();
        $getFollow2->close();

        if($followData2->num_rows == 0){
            $following = 'no';
        } else {
            $following = 'yep';
        }
    ?>
    <div class="perfil">
        <div class="perfil-info">
            <img src="<?php echo $userPicture; ?>" alt="Imagem-Perfil">
            <div class="nome">
                <?php echo $userName; ?>
            </div>
            <?php if(in_array($userAccess, ['verified','adm'])){ echo '<i class="feather-check"></i>';} ?>
        </div>
        <i class="feather-alert-triangle" onclick="reportUser(<?php echo $_SESSION['profUserId']; ?>)"></i>
        <div class="follows">
            <button id='followUser' onclick="followUser(<?php echo $_SESSION['profUserId']; ?>)">
                <?php echo ($following == 'no' ? 'Seguir' : 'Abandonar'); ?>
            </button>
            <div id='totFollow'>
                <?php echo $totFollow; ?>
            </div>
        </div>
    </div>
    <div class="bio">
        <h3>Bio</h3>
        <div>
            <?php echo $userBio; ?>
        </div>
    </div>
    <div class="feedTray">
        
    </div>
</body>
<script src="../js/feedFunctions.js"></script>
<script>
    // eventos
    loadFeed('prof');
    window.addEventListener("scroll", function(){loadFeed('prof');});
</script>
<script src="../js/userFunctions.js"></script>
</html>