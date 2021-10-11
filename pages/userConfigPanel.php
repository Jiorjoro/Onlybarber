<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/userConfig.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Configurações | Onlybarber</title>
</head>
<body>
<div id="body">
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
        }

    ?>

    <div class="config">
        <form action="../php/userConfig.php" class="image" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="pic">
            <input type='hidden' name='MAX_FILE_SIZE' value='50000000'>
            <div class="botoes">
                <label for="new-pic">
                    <i class="feather-paperclip"></i>Escolha uma Imagem
                </label>
                <input type="file" name="new-pic" id="new-pic" accept="image/*">
                <input type="submit" name="submit" value="Alterar">
            </div>
            <div class="erro">
                <?php
                    if(isset($_SESSION['uploadErr'])){
                        echo $_SESSION['uploadErr'];
                    }
                ?>
            </div>
        </form>

        <form action="#" class="bio" method="POST" onsubmit="changeBio(this)">
            <input type="hidden" name="action" value="bio">
            <textarea name="bio" placeholder="Altere Sua Bio" maxlength="300"></textarea>
            <input type="submit" value="Alterar">
        </form>

        <form action="#" class="password" method="POST" onsubmit="changePass(this)">
            <input type="hidden" name="action" value="pass">
            <input type="password" name="oldpass" placeholder="Senha Anterior" maxlength="32">
            <input type="password" name="newpass" placeholder="Nova Senha" maxlength="32">
            <input type="password" name="newpass2" placeholder="Confirmar Nova Senha" maxlength="32">
            <input type="submit" value="Alterar">
            <div class="erro">
            </div>
        </form>

        <form class="delete" onsubmit="deleteAccount()">
            <div>
                DELETA A CONTA, SUAS POSTAGENS E COMENTÁRIOS
            </div>
            <input type="submit" value="DELETAR CONTA">
        </form>
    </div>
</div>
</body>
<script src="../js/userFunctions.js"></script>
</html>