<?php

    session_start();

    require "dbconn.php";
    require "functions.php";

    $storyId = $_POST['storyId'];
    $storyUserId = $_POST['storyUserId'];
    $response = [];

    if($storyUserId == $_SESSION['userId']){
        $sql = $conn->prepare("UPDATE stories SET storyStatus='del' WHERE storyId=? AND storyUserId=?");
        $sql->bind_param('ii', $storyId, $storyUserId);
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