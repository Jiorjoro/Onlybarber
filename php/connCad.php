<?php

    session_start();

    require "dbconn.php"; // dados da conexão
    require "functions.php"; // filtro

    // $data = json_decode($_POST['data']); pega as variáveis
    
    /*  sanitiza
    $email = qBoa($data->email);
    $senha = qBoa($data->senha);
    $senha = md5($senha);
    $userName = qBoa($data->userName); */

    // sanitiza
    $email = $_SESSION['email'] = qBoa($_POST['email']);
    $senha = $_SESSION['senha'] = qBoa($_POST['senha']);
    $senhaConf = $_SESSION['senhaConf'] = qBoa($_POST['senhaConf']);
    $userName = $_SESSION['userName'] = qBoa($_POST['userName']);

    if(empty($email) || empty($senha) || empty($senhaConf) || empty($userName)){
        $_SESSION['error'] = "Preencha os Campos";
        header("Location: ../pages/cadastro.php");
        exit();
    }

    if(strlen($senha) > 32){
        $_SESSION['error'] = "Senha limite: 32 caracters";
        header("Location: ../pages/cadastro.php");
        exit();
    }

    if($senha != $senhaConf){
        $_SESSION['error'] = "Senhas não Coincidem";
        header("Location: ../pages/cadastro.php");
        exit();
    }

    if(strpos($userName, ' ')){
        $_SESSION['error'] = "Proibidos Espaços na @";
        header("Location: ../pages/cadastro.php");
        exit();
    } else {
        $userName = str_replace('@', '', $userName);
    }
    
    if(empty($_POST['terms']) || $_POST['terms'] != 'ok'){
        $_SESSION['error'] = "É necessário aceitar os termos";
        header("Location: ../pages/cadastro.php");
        exit();
    }

    $senha = md5($senha);
    
    // comando do sql
    $sql = $conn->prepare("SELECT userId FROM logins WHERE email=?");
    $sql->bind_param("s", $email);
    $sql->execute();
    $result = $sql->get_result();
    $sql->close();

    // email já cadastrado?
    if($result->num_rows > 0){
        $_SESSION['error'] = "Email já Cadastrado";
        header("Location: ../pages/cadastro.php");
        exit();

    } else { // email disponível

        //* início do código da imagem
        if (!empty($_FILES['userPic']['tmp_name'])) {
            // define o horário
            date_default_timezone_set("America/Belem"); 

            //preparação dos dados			
            $target_dir = "../media/usersPictures/"; // pasta onde vai
            $extension = strtolower(pathinfo(basename($_FILES["userPic"]["name"]), PATHINFO_EXTENSION)); // extensão
            $target_file = $target_dir .  date("Ymd_His") . '.' . $extension;
            $uploadErr = ''; // erro pra retornar ao usuário

            // limite de tamanho (em bytes)
			if ($_FILES['userPic']['size'] > 50000000) {
				$uploadErr =  'Limite (50MB) Excedido';
			}
            
            // checa as extensões
            $permitedExt = ['png', 'jpg', 'jpeg', 'jfif', 'gif', 'webp'];
            if(!in_array($extension, $permitedExt)){
                $uploadErr = 'Formato Incompatível.';
            }

            if ($uploadErr == '') { // arquivo aceito
				move_uploaded_file($_FILES['userPic']['tmp_name'], $target_file);
            } else { // arquivo inválido
                $_SESSION['error'] = $uploadErr;
                header("Location: ../pages/cadastro.php");
                exit();
            }
        } else {
            $target_file = "../media/usersPictures/defaultIcon.png";
        }
        //* fim do código da imagem                      

        // lança n bd
        $singin = $conn->prepare("INSERT INTO logins (email, senha, userName, userPicture) VALUES (?, ?, ?, ?)");
        $singin->bind_param("ssss", $email, $senha, $userName, $target_file);
        $singin->execute();

        // remove os erros
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        unset($_SESSION['senhaConf']);
        unset($_SESSION['userName']);
        unset($_SESSION['error']);
        
        $conn->close();
        header("Location: ../pages/login.php");
        exit();
        /* $toSend = json_encode(["error"=>"", "head"=>"window.location.href='login.php';"]);
        echo $toSend; */

    }
    
    echo $_SESSION['error'];
    header("Location: ../pages/login.php");
    exit();

?>