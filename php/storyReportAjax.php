<?php

    session_start();

    if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])){
        $response['error'] = 1;
        $response['msg'] = "";
        $response = json_encode($response);
        echo $response;
        exit();
    }

    require "functions.php";
    require "dbconn.php";

    $storyId = qBoa($_POST['storyId']);
    $userId = $_SESSION['userId'];

    $checkSql = $conn->prepare("SELECT reportId FROM storyReports WHERE reportStoryId=? AND reportUserId=?");
    $checkSql->bind_param("ii", $storyId, $userId);
    $checkSql->execute();
    $checkRes = $checkSql->get_result();

    if($checkRes->num_rows == 0){

        $reportSql = $conn->prepare("INSERT INTO storyReports (reportStoryId, reportUserId) VALUES (?, ?)");
        $reportSql->bind_param("ii", $storyId, $userId);
        $reportSql->execute();
        $reportSql->close();

        $response['error'] = 0;
        $response['msg'] = "Obrigado Por Sua Denúncia!";
    } elseif($checkRes->num_rows > 0) {
        $response['error'] = 0;
        $response['msg'] = "Você já denunciou este story";
    }
        
    $response = json_encode($response);
    echo $response;

?>