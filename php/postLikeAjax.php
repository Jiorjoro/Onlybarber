<?php

    session_start();

    if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])){
        $response['error'] = 1;
        $response['class'] = "";
        $response['totLike'] = "";
        $response = json_encode($response);
        echo $response;
        exit();
    }

    require "functions.php";
    require "dbconn.php";

    $postId = qBoa($_POST['postId']);
    $userId = $_SESSION['userId'];

    $checkSql = $conn->prepare("SELECT likeId FROM postLikes WHERE likePostId=? AND likeUserId=?");
    $checkSql->bind_param("ii", $postId, $userId);
    $checkSql->execute();
    $checkRes = $checkSql->get_result();

    if($checkRes->num_rows == 0){
        $stmt = $conn->prepare("INSERT INTO postLikes (likePostId, likeUserId) VALUES (?, ?)");
        $stmt->bind_param('ii', $postId, $userId);
        $stmt->execute();
        $stmt->close();
        
        $response['class'] = "../media/default/fullLike.png";
    } elseif($checkRes->num_rows > 0) {
        while($rowC = $checkRes->fetch_assoc()){
            $likeId = $rowC['likeId'];

            $stmt = $conn->prepare("DELETE FROM `postLikes` WHERE likeId=?");
            $stmt->bind_param('i', $likeId);
            $stmt->execute();
            $stmt->close();

            $response['class'] = "../media/default/emptyLike.png";
        }
    }

    $checkRes->close();

    //quantidade de likes
    $sqlL = $conn->prepare("SELECT COUNT(likeId) AS totLike FROM postLikes WHERE likePostId=?");
    $sqlL->bind_param('i', $postId);
    $sqlL->execute();
    $likeRes = $sqlL->get_result();

    while($rowL = $likeRes->fetch_assoc()){
        $postTotLike = $rowL['totLike'];
    }

    $likeRes->close();

    $notfTxt = "";
    if($postTotLike == 50){
        $notfTxt = "Você bateu 50 likes em uma Postagem!";
    }
    if($postTotLike == 100){
        $notfTxt = "Você bateu 100 likes em uma Postagem!";
    }
    if($postTotLike == 500){
        $notfTxt = "Você bateu 500 likes em uma Postagem!";
    }
    if($postTotLike == 1000){
        $notfTxt = "Você bateu 1000 likes em uma Postagem!";
    }

    if($notfTxt != ""){
        $getPU = $conn->prepare("SELECT postUserId from posts WHERE postId=?");
        $getPU->bind_param('i', $postId);
        $getPU->execute();
        $PU = $getPU->get_result();
        $getPU->close();
        $rowPU = $PU->fetch_all(MYSQLI_NUM);
        $postUserId = $rowPU[0][0];
        $notfLink = "http://localhost:8080/onlibar/pages/sharePost.php?postId=".$postId;

        $notify = $conn->prepare("INSERT INTO notifications (notificationUserId, notificationLink, notificationTxt) VALUES (?, ?, ?);");
        $notify->bind_param('iss', $postUserId, $notfLink, $notfTxt);
        $echo = $notify->execute();
        $notify->close();
    }
    

    $response['totLike'] = numerin($postTotLike);
    $response = json_encode($response);
    echo $response;