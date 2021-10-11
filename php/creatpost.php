<?php

    require 'functions.php';
        
    if (!empty(qBoa($_POST['postTxt'])) || !empty($_FILES['postUpload']['tmp_name'])) {

        session_start();	

        //pega variaveis
		$postUserId = $_SESSION['userId'];
		$postTxt = $_SESSION['postTxt'] = qBoa($_POST['postTxt']);
		$postImg = '';	
		$postVideo = '';

        //* início do código de upload
        if (!empty($_FILES['postUpload']['tmp_name'])) {

            // define o horário
            date_default_timezone_set("America/Belem");

            //preparação dos dados			
            $target_dir = "../media/uploads/"; // pasta onde vai
            $extension = strtolower(pathinfo(basename($_FILES["postUpload"]["name"]), PATHINFO_EXTENSION)); // extensão
            $target_file = $target_dir .  date("Ymd_His_") . $postUserId . '.' . $extension;
            $fileMime = explode('/', $_FILES['postUpload']['type'])[0]; // imagem / video
            $uploadErr = ''; // erro pra retornar ao usuário

            // limite de tamanho (em bytes)
			if ($_FILES['postUpload']['size'] > 50000000) {
				$uploadErr =  'Limite (50MB) Excedido';
			}
            
            // checa as extensões
            $permitedExt = ['png', 'jpg', 'jpeg', 'jfif', 'gif', 'webp'];
            array_push($permitedExt, 'mp4', 'mov', 'mpg', 'mpeg', 'wmv', 'mkv', 'webm');
            if(!in_array($extension, $permitedExt)){
                $uploadErr = 'Formato Incompatível.';
            }

            // é imagem?
            $check = getimagesize($_FILES['postUpload']['tmp_name']);
            if ($check !== false) {

            } else if ( $fileMime == 'image' || $fileMime == 'video') {
                //nada muda, era só pra testar mermo
            } else {
                $uploadErr = "Arquivo Inválido";
            }

            if ($uploadErr == '') { // arquivo aceito				
                move_uploaded_file($_FILES['postUpload']['tmp_name'], $target_file);
                
                if ($fileMime == 'image') {
					$postImg = $target_file;
				} else if ($fileMime == 'video') {
					$postVideo = $target_file;
				}

				unset($_SESSION['uploadErr']);

            } else { // arquivo inválido

                $_SESSION['uploadErr'] = $uploadErr;
                header("Location: ../pages/emalta.php");
                exit();

            }
        }
        //* fim do código de upload
		
        // define as tags
        if(!empty($postTxt)){
            $postTags = [];
            $userNotify = [];
            $piece = explode(' ', $postTxt);
            foreach($piece as $tok){
                if(strpos($tok, "#") !== false){
                    array_push($postTags, $tok);
                }
                if(strpos($tok, "@") == 0){
                    array_push($userNotify, $tok);
                }
            }
            
        }
        
        require 'dbconn.php';

        // insere no bd
        $sql = $conn->prepare("INSERT INTO `posts` (`postUserId`, `postTxt`, `postImg`, `postVideo`) VALUES (?, ?, ?, ?)");
        $sql->bind_param('isss', $postUserId, $postTxt, $postImg, $postVideo);
        $sql->execute();
        $postId = $conn->insert_id;
        $sql->close();

        if(!empty($postTxt)){

            // adiciona cada tag individual
            foreach($postTags as $tag){

                $sqlTag = $conn->prepare("INSERT INTO postTags (`tagPostId`, `tagTxt`) VALUES (?, ?)");
                $sqlTag->bind_param('is', $postId, $tag);
                $sqlTag->execute();
                $sqlTag->close();

            }

            foreach($userNotify as $name){
                $name = str_replace('@', '', $name);
                
                $addNotify = $conn->prepare("SELECT userId FROM logins WHERE userName=?;");
                $addNotify->bind_param('s', $name);
                $addNotify->execute();
                $notifyRes = $addNotify->get_result();
                $addNotify->close();
                
                $notifyUser = 0;
                
                while($rowNtf = $notifyRes->fetch_assoc()){
                    $notifyUser = $rowNtf['userId'];
                }

                $postTxt = str_replace('@'.$name, '<a href="../pages/perfil.php?pU='.$notifyUser.'">@'.$name.'</a>', $postTxt);

                $notfLink = "http://onlybarber.net/pages/sharePost.php?postId=".$postId;
                $notfTxt = "Alguém te marcou em uma postagem!";

                $sendNotify = "INSERT INTO notifications (notificationUserId, notificationLink, notificationTxt) 
                VALUES ('{$notifyUser}', '{$notfLink}', '{$notfTxt}')";
                $conn->query($sendNotify);

                $changePost = "UPDATE posts SET postTxt='{$postTxt}' WHERE postId='{$postId}'";
                $conn->query($changePost);
            }
        }

        unset($_SESSION['postTxt']);
        unset($_SESSION['uploadErr']);

        $conn->close();

    }

    // devolve pro site
    header("Location: ../pages/emalta.php");
    exit();

?>