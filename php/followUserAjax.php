<?php

    session_start();

    if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])){
        $response['error'] = 1;
        $response['fb'] = "";
        $response['tf'] = "";
        $response = json_encode($response);
        echo $response;
        exit();
    } else {
        $response['error'] = 0;
    }

    require "functions.php";
    require "dbconn.php";

    $followedId = qBoa($_POST['followed']);
    $userId = $_SESSION['userId'];

    $checkSql = $conn->prepare("SELECT followId FROM follows WHERE followedId=? AND followerId=?");
    $checkSql->bind_param("ii", $followedId, $userId);
    $checkSql->execute();
    $checkRes = $checkSql->get_result();

    if($checkRes->num_rows == 0){
        $stmt = $conn->prepare("INSERT INTO follows (followedId, followerId) VALUES (?, ?)");
        $stmt->bind_param('ii', $followedId, $userId);
        $stmt->execute();
        $stmt->close();

        $response['fb'] = "Abandonar";
    } elseif($checkRes->num_rows > 0){
        while($rowC = $checkRes->fetch_assoc()){
            $followId = $rowC['followId'];

            $stmt = $conn->prepare("DELETE FROM follows WHERE followId=?");
            $stmt->bind_param('i', $followId);
            $stmt->execute();
            $stmt->close();

            $response['fb'] = "Seguir";
        }
    }

    $sqlF = $conn->prepare("SELECT COUNT(followId) AS totFollow FROM follows WHERE followedId=?");
    $sqlF->bind_param('i', $followedId);
    $sqlF->execute();
    $followRes = $sqlF->get_result();
    $sqlF->close();

    while($rowF = $followRes->fetch_assoc()){
        $totFollow = $rowF['totFollow'];
    }
    if($followRes->num_rows == 0){
        $totFollow = 0;
    }
    
    $notfTxt = "";
    if($totFollow == 50){
        $notfTxt = "Você atingiu 50 seguidores!";
    }
    if($totFollow == 100){
        $notfTxt = "Você atingiu 100 seguidores!";
    }
    if($totFollow == 500){
        $notfTxt = "Você atingiu 500 seguidores!";
    }
    if($totFollow == 1000){
        $notfTxt = "Você atingiu 1000 seguidores!";
    }
    if($notfTxt != ""){
        $notfLink = "../pages/perfil.php?pU=".$userId;

        $notify = $conn->prepare("INSERT INTO notifications (notificationUserId, notificationLink, notificationTxt) VALUES (?, ?, ?);");
        $notify->bind_param('iss', $userId, $notfLink, $notfTxt);
        $echo = $notify->execute();
        $notify->close();
    }

    $response['tf'] = $totFollow;
    $response = json_encode($response);
    echo $response;
    exit();
    
?>

