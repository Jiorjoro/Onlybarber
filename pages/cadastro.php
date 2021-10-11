<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Cadastro | Onlybarber</title>
</head>
<body>
    <div class="singinArea">
        <center>
            <img src="../media/default/logo.png" alt="Onlybarber-Logo" />
        </center>
        <form action="../php/connCad.php" method="POST" enctype="multipart/form-data" >
            <input type="text" max-length="150" placeholder="Email" name="email" value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } ?>" />
            <i class="feather-at-sign"></i><input type="text" max-length="200" placeholder="Nome" name="userName" value="<?php if(isset($_SESSION['userName'])){ echo $_SESSION['userName']; } ?>" />
            <input type="password" placeholder="Senha" name="senha" maxlength="32" value="<?php if(isset($_SESSION['senha'])){ echo $_SESSION['senha']; } ?>" />
            <input type="password" placeholder="Confirmar Senha" name="senhaConf" maxlength="32" value="<?php if(isset($_SESSION['senhaConf'])){ echo $_SESSION['senhaConf']; } ?>" />
            <input type='hidden' name='MAX_FILE_SIZE' value='50000000' />
            <label for="userPic">
                <i class="feather-paperclip"></i>
                Escolha sua foto
            </label>
            <input type="file" name="userPic" id="userPic" accept="image/*" />
            <br>
            <lable class="terms">
                <input type="checkbox" name="terms" value="ok">
                <span>
                    Li e Concordo com os 
                    <a href="termos.php" target="_blank"> termos de uso</a> 
                     e 
                    <a href="privacidade.php" target="_blank"> politica de privacidade</a>.
                </span>
            </lable>
            <br>
            <div>
                <?php
                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'];
                    }
                ?>
            </div>
            <center><input type="submit" value="Cadastrar" /></center>
        </form>
        <br>
        <div>
            Já tem conta? <a href="login.php">Entrar</a>
        </div>
    </div>
</body>
<script src="../js/login.js"></script>
</html>