<?php

    require 'functions.php';
        
    if (!empty($_FILES['storyUpload']['tmp_name'])) {

        session_start();	

        //pega variaveis
		$storyUserId = $_SESSION['userId'];
		$storyImg = '';	
		$storyVideo = '';

        // define o horário
        date_default_timezone_set("America/Belem");

        //preparação dos dados			
        $target_dir = "../media/uploads/"; // pasta onde vai
        $extension = strtolower(pathinfo(basename($_FILES["storyUpload"]["name"]), PATHINFO_EXTENSION)); // extensão
        $target_file = $target_dir .  date("Ymd_His_") . $storyUserId . '.' . $extension;
        $fileMime = explode('/', $_FILES['storyUpload']['type'])[0]; // imagem / video
        $uploadErr = ''; // erro pra retornar ao usuário

        // limite de tamanho (em bytes)
        if ($_FILES['storyUpload']['size'] > 50000000) {
            $uploadErr =  'Limite (50MB) Excedido';
        }
        
        // checa as extensões
        $permitedExt = ['png', 'jpg', 'jpeg', 'jfif', 'gif', 'webp'];
        array_push($permitedExt, 'mp4', 'mov', 'mpg', 'mpeg', 'wmv', 'mkv', 'webm');
        if(!in_array($extension, $permitedExt)){
            $uploadErr = 'Formato Incompatível.';
        }

        // é imagem?
        $check = getimagesize($_FILES['storyUpload']['tmp_name']);
        if ($check !== false) {
            echo $check['mime'];
        } else if ( $fileMime == 'image' || $fileMime == 'video') {
            //nada muda, era só pra testar mermo
        } else {
            $uploadErr = "Arquivo Inválido";
        }

        if ($uploadErr == '') { // arquivo aceito				
            move_uploaded_file($_FILES['storyUpload']['tmp_name'], $target_file);
            
            if ($fileMime == 'image') {
                $storyImg = $target_file;
            } else if ($fileMime == 'video') {
                $storyVideo = $target_file;
            }

            unset($_SESSION['storyErr']);

        } else { // arquivo inválido

            $_SESSION['storyErr'] = $uploadErr;
            header("Location: ../pages/stories.php");
            exit();

        
        }
        //* fim do código de upload

        require 'dbconn.php';

        // insere no bd
        $sql = $conn->prepare("INSERT INTO stories (`storyUserId`, `storyImg`, `storyVideo`) VALUES (?, ?, ?)");
        var_dump($sql);
        $sql->bind_param('iss', $storyUserId, $storyImg, $storyVideo);
        $sql->execute();
        $sql->close();

        unset($_SESSION['storyErr']);

        $conn->close();

    } else {
        $_SESSION['storyErr'] = "Sem Arquivos";
    }

    // devolve pro site
    header("Location: ../pages/stories.php");
    exit();

?>