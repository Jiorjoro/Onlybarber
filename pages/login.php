<!DOCTYPE html>
<html lang="en">
<?php
    //* automaticamente joga pro site

    session_start();
    
    if(!isset($_SESSION['userId']) || !isset($_SESSION['userPicture'])){

        if(isset($_COOKIE['userId']) || isset($_COOKIE['userId']) 
        || !empty($_COOKIE['userId']) || !empty($_COOKIE['userPicture'])){
            
            $_SESSION['userId'] = $_COOKIE['userId'];
            $_SESSION['userPicture'] = $_COOKIE['userPicture'];

            // TODO: TROCAR LINK PELO REAL
            header("Location: ../pages/emalta.php", 301);
        }

    } else {
        // TODO: TROCAR LINK PELO REAL
        header("Location: ../pages/emalta.php", 301);
    }

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="Keywords" content="Barber, Barbearia, Bigode, Mustache, Barba, Beard, Cabelo, Hair">
    <link href="../fonts/feather.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/global.css">
    <link rel='shortcut icon' href="../media/default/logo.png">
    <title>Login | Onlybarber</title>
</head>
<body>
    <div class="welcome">
        <img src="../media/default/logo.png" />
        <div>
            <h2>Bem Vindo</h2>
            <div>
                O ONLYBARBER tem o intuito de auxiliar os barbeiros! 
                Esta plataforma foi criada para que barbeiros 
                troquem ideias sobre tendências de cortes de 
                cabelos e acima de tudo isso criar novos 
                amigos na mesma área de trabalho.
            </div>
        </div>
    </div>
    <div class="loginArea">
        <form methood="POST" action="#">
            <input type="text" placeholder="Email" name="email" />
            <input type="password" placeholder="Senha" name="senha" maxlength="32" />
            <input type="checkbox" name="keepLoged" id="keepLoged" value="keep" />            
            <label for="keepLoged">Manter-se Conectado</label>
            <br>
            <div>
                
            </div>
            <br>
            <center><input type="submit" value="Logar" onclick="login()" /></center>
        </form>
        <br>
        <div class="cadastrar">
            Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a>
        </div>
        <br>
        <center>
            <div class="noLog">
                <a href="emalta.php">Entrar Sem Login</a>
            </div>
        </center>
    </div>
</body>
<script src="../js/login.js"></script>
</html>