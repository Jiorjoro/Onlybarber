<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/stories.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Stories | Onlybarber</title>
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
        // caixinha de notificação
        if(isset($_SESSION['userId'])){
            include "../templates/notification.php";

            echo '<form action="../php/creatstory.php" class="new-story" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="MAX_FILE_SIZE" value="50000000">
            <div class="botoes">
                <label for="new-story">
                    <i class="feather-paperclip"></i>Escolha uma Imagem
                </label>
                <input type="file" name="storyUpload" id="new-story" accept="image/*">
                <input type="submit" name="submit" value="Publicar">
            </div>
            <div class="erro">';
                if(isset($_SESSION['storyErr'])){
                    echo $_SESSION['storyErr'];
                }
            echo '</div>
            </form>';
        }

    ?>

    <div class="storiesTray">
        <?php

            require "../php/dbconn.php";

            if(isset($_SESSION['userId']) && !empty($_SESSION['userId'])){
                $userId = $_SESSION['userId'];
            } else {
                $userId = 0;
            }

            $sql = "SELECT u.userId, u.userName, u.userPicture FROM logins AS u 
            INNER JOIN stories AS s ON s.storyUserId=u.userId 
            INNER JOIN follows AS f ON f.followedId=s.storyUserId 
            WHERE s.storyStatus = 'on' 
            AND s.storyDate >= (DATE(NOW()) - INTERVAL 1 DAY) 
            AND f.followerId='{$userId}' 
            GROUP BY u.userId";
            $result = $conn->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $storyUserId = $row['userId'];
                    $storyUserName = $row['userName'];
                    $storyUserPicture = $row['userPicture'];

                    include "../templates/storyProfile.php";
                }
            } else {
                echo "<h2>Sem Stories</h2>";
            }
            $conn->close();

        ?>
    </div>

    <div class="storyContainer hidden">
        <i class="feather-x" onclick="closeStory()"></i>
    </div>
</body>
<script src="../js/userFunctions.js"></script>
<script src="../js/storyFunctions.js"></script>
</html>