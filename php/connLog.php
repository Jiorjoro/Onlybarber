<?php

    session_start();

    require "dbconn.php"; // dados da conexão
    require "functions.php"; // filtro

    $data = json_decode($_POST['data']); // pega as variáveis

    // sanitiza
    $email = qBoa($data->email);
    $senha = qBoa($data->senha);
    $senha = md5($senha);

    // comando do sql
    $sql = $conn->prepare("SELECT userId, userPicture, userAccess FROM logins WHERE email=? AND senha=?");
    $sql->bind_param("ss", $email, $senha);
    $sql->execute();
    $result = $sql->get_result();

    // foram encontrados registros?
    if($result->num_rows == 1){

        while($row = $result->fetch_assoc()){ 

            if($row['userAccess'] == 'banido'){
                $toSend = json_encode(["error"=>"Usuário Banido", "head"=>""]);
                echo $toSend;
                exit();
            }
            if($row['userAccess'] == 'del'){
                $toSend = json_encode(["error"=>"Conta Desativada", "head"=>""]);
                echo $toSend;
                exit();
            }
           
            // salva os dados nos cookies
            if($data->keepLog == "keep"){
                setcookie('userId', $row['userId'], time() + (86400 * 7), "/");
                setcookie('userPicture', $row['userPicture'], time() + (86400 * 7), "/");
            }
            //salva em sessão
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['userPicture'] = $row['userPicture'];

        }

        // TODO: TROCAR PELO SITE CORRETO!!
        $toSend = json_encode(["error"=>"", "head"=>"window.location.href='emalta.php';"]);
        echo $toSend;

    } else { // nenhum registro

        // mensagem para o usuário
        $toSend = json_encode(["error"=>"Dados Inválidos", "head"=>""]);
        echo $toSend;

    }

    $sql->close();
    $conn->close();
    exit();

?>