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

    $storyId = qBoa($_POST['storyId']);
    $userId = $_SESSION['userId'];

    $checkSql = $conn->prepare("SELECT likeId FROM storyLikes WHERE likeStoryId=? AND likeUserId=?");
    $checkSql->bind_param("ii", $storyId, $userId);
    $checkSql->execute();
    $checkRes = $checkSql->get_result();

    if($checkRes->num_rows == 0){
        $stmt = $conn->prepare("INSERT INTO storyLikes (likeStoryId, likeUserId) VALUES (?, ?)");
        $stmt->bind_param('ii', $storyId, $userId);
        $stmt->execute();
        $stmt->close();
        
        $response['class'] = "../media/default/fullLike.png";
    } elseif($checkRes->num_rows > 0) {
        while($rowC = $checkRes->fetch_assoc()){
            $likeId = $rowC['likeId'];

            $stmt = $conn->prepare("DELETE FROM `storyLikes` WHERE likeId=?");
            $stmt->bind_param('i', $likeId);
            $stmt->execute();
            $stmt->close();

            $response['class'] = "../media/default/emptyLike.png";
        }
    }

    $checkRes->close();

    //quantidade de likes
    $sqlL = $conn->prepare("SELECT COUNT(likeId) AS totLike FROM storyLikes WHERE likeStoryId=?");
    $sqlL->bind_param('i', $storyId);
    $sqlL->execute();
    $likeRes = $sqlL->get_result();

    while($rowL = $likeRes->fetch_assoc()){
        $storyTotLike = $rowL['totLike'];
    }

    $likeRes->close();

    $response['totLike'] = numerin($storyTotLike);
    $response = json_encode($response);
    echo $response;