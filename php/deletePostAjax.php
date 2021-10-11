<?php

    session_start();

    require "dbconn.php";
    require "functions.php";

    $postId = $_POST['postId'];
    $postUserId = $_POST['postUserId'];
    $response = [];

    if($postUserId == $_SESSION['userId']){
        $sql = $conn->prepare("UPDATE posts SET postStatus='del' WHERE postId=? AND postUserId=?");
        $sql->bind_param('ii', $postId, $postUserId);
        $error = $sql->execute();
        $sql->close();

        if($error == true){
            $response['error'] = 0;
        } else {
            $response['error'] = 1;
        }
    } else {
        $response['error'] = 1;
    }

    $response = json_encode($response);
    echo $response;
    $conn->close();

?>