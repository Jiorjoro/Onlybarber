<?php

    session_start();

    require "dbconn.php";
    require "functions.php";

    $action = qBoa($_POST['action']);

    $response = [];

    switch($action){
        case 'pic':

            if(!empty($_FILES["new-pic"]['tmp_name'])){
                // define o horário
                date_default_timezone_set("America/Belem");

                //preparação dos dados			
                $target_dir = "../media/usersPictures/"; // pasta onde vai
                $extension = strtolower(pathinfo(basename($_FILES["new-pic"]["name"]), PATHINFO_EXTENSION)); // extensão
                $target_file = $target_dir .  date("Ymd_His_") . $_SESSION['userId'] . '.' . $extension;
                $fileMime = explode('/', $_FILES['new-pic']['type'])[0]; // imagem / video
                $uploadErr = ''; // erro pra retornar ao usuário

                // limite de tamanho (em bytes)
                if ($_FILES['new-pic']['size'] > 50000000) {
                    $uploadErr =  'Limite (50MB) Excedido';
                }
                
                // checa as extensões
                $permitedExt = ['png', 'jpg', 'jpeg', 'jfif', 'gif', 'webp'];
                if(!in_array($extension, $permitedExt)){
                    $uploadErr = 'Formato Incompatível.';
                }

                // é imagem?
                $check = getimagesize($_FILES['new-pic']['tmp_name']);
                if ($check !== false) {
                    //nada
                } else if ( $fileMime == 'image') {
                    //nada muda, era só pra testar mermo
                } else {
                    $uploadErr = "Arquivo Inválido"; // aqui muda XD
                }

                if ($uploadErr == '') { // arquivo aceito				
                    move_uploaded_file($_FILES['new-pic']['tmp_name'], $target_file);

                    $sql = "UPDATE logins SET userPicture='{$target_file}' WHERE userId='{$_SESSION['userId']}'";
                    $conn->query($sql);

                    $_SESSION['userPicture'] = $target_file;
                    unset($_SESSION['uploadErr']);
                    header("Location: ../pages/userConfigPanel.php");
                    exit();
                } else {
                    $_SESSION['uploadErr'] = $uploadErr;
                    header("Location: ../pages/userConfigPanel.php");
                    exit();
                }
            } else {
                $_SESSION['uploadErr'] = "Sem Arquivos";
                header("Location: ../pages/userConfigPanel.php");
                exit();
            }
            break;
        case 'bio':

            $userBio = qBoa($_POST['bio']);

            $sql = $conn->prepare("UPDATE logins SET userBio=? WHERE userId=?");
            $sql->bind_param('si', $userBio, $_SESSION['userId']);
            $sql->execute();
            $sql->close();
            exit();

            break;
        case 'pass':

            $oldpass = qBoa($_POST['oldpass']);
            $oldpass = md5($oldpass);

            $check = "SELECT senha FROM logins WHERE userId='{$_SESSION['userId']}';";
            $check = $conn->query($check);
            $row = $check->fetch_all(MYSQLI_NUM);

            if($row[0][0] != $oldpass){
                $response['error'] = "Senha Antiga Incorreta";
                $response = json_encode($response);
                echo $response;
                exit();
            }

            $newpass = qBoa($_POST['newpass']);
            $newpass2 = qBoa($_POST['newpass2']);

            if($newpass != $newpass2){
                $response['error'] = "Novas Senhas Não Coincidem";
                $response = json_encode($response);
                echo $response;
                exit();
            }

            $newpassword = md5($newpass);

            $sql = $conn->prepare("UPDATE logins SET senha=? WHERE userId=?");
            $sql->bind_param('si', $newpassword, $_SESSION['userId']);
            $sql->execute();
            $sql->close();

            $response['error'] = '';
            $response = json_encode($response);
            echo $response;

            exit();

            break;
        case 'del':

            $senha = qBoa($_POST['senha']);
            $senha = md5($senha);

            $check = "SELECT senha FROM logins WHERE userId='{$_SESSION['userId']}';";
            $check = $conn->query($check);
            $row = $check->fetch_all(MYSQLI_NUM);

            if($row[0][0] != $senha){
                $response['error'] = "SENHA INCORRETA";
                $response = json_encode($response);
                echo $response;
                exit();
            } else {
                $account = "UPDATE logins SET userAccess='del' WHERE userId='{$_SESSION['userId']}'";
                $account = $conn->query($account);

                $post = "UPDATE posts SET postStatus='del' WHERE postUserId='{$_SESSION['userId']}'";
                $post = $conn->query($post);

                $comm = "UPDATE postComments SET commentStatus='del' WHERE commentUserId='{$_SESSION['userId']}'";
                $comm = $conn->query($comm);

                $conn->close();

                session_unset();
                session_destroy();

                if(isset($_COOKIE['userId']) || isset($_COOKIE['userPicture'])){
                    setcookie('userId', '', time() - (86400 * 9), "/");
                    setcookie('userPicture', '', time() - (86400 * 9), "/");
                    unset($_COOKIE['userId']);
                    unset($_COOKIE['userPicture']);
                }

                $response['error'] = '';
                $response = json_encode($response);
                echo $response;
                exit();
            }

            break;
    }

    $conn->close();
    exit();

?>