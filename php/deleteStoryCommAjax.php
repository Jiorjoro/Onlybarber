<?php

    session_start();

    require "dbconn.php";
    require "functions.php";

    $commentId = $_POST['commentId'];
    $commentUserId = $_POST['commentUserId'];
    $response = [];

    if($commentUserId == $_SESSION['userId']){
        $sql = $conn->prepare("UPDATE storyComments SET commentStatus='del' WHERE commentId=? AND commentUserId=?");
        $sql->bind_param('ii', $commentId, $commentUserId);
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