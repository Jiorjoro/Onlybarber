<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/hashes.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Hashtags | Onlybarber</title>
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
        }
    ?>
    <div class="hashes">
        <table class="title">
            <tr>
                <td style="width: 20%">
                    Posição
                </td>
                <td style="width: 20%">
                    Uso
                </td>
                <td style="width: 60%">
                    Tag
                </td>
            </tr>
        </table>
        <?php
            
            require "../php/dbconn.php";
            require "../php/functions.php";

            $sql = "SELECT COUNT(tagId) as totUse, tagTxt 
            FROM postTags WHERE tagTxt != '' 
            AND tagTxt != ' ' AND tagTxt != '\n' 
            AND tagDate >= (DATE(NOW()) - INTERVAL 6 WEEK) 
            GROUP BY tagTxt ORDER BY totUse DESC LIMIT 100";
            $result = $conn->query($sql);

            $contador = 1;
            while($row = $result->fetch_assoc()){
                $totUse = $row['totUse'];
                $tagTxt = $row['tagTxt'];

                echo '<form action="busca.php" method="post">';
                    echo '<input type="hidden" name="scope" value="tag">';
                    echo '<input type="hidden" name="search" value="'.$tagTxt.'">';
                    echo '<input type="submit" value="'.$contador.'" class="position">';
                    echo '<input type="submit" value="'.numerin($totUse).'" class="uses">';
                    echo '<input type="submit" value="'.$tagTxt.'" class="tag">';
                echo '</form>';

                $contador++;
            }

        ?>
    </div>
</body>
<script src="../js/userFunctions.js"></script>
</html>