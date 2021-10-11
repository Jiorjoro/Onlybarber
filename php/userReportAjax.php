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

    $repUserId = qBoa($_POST['repUserId']);
    $userId = $_SESSION['userId'];

    $checkSql = $conn->prepare("SELECT reportId FROM userReports WHERE reportedUserId=? AND reportingUserId=?");
    $checkSql->bind_param("ii", $repUserId, $userId);
    $checkSql->execute();
    $checkRes = $checkSql->get_result();

    if($checkRes->num_rows == 0){

        $reportSql = $conn->prepare("INSERT INTO userReports (reportedUserId, reportingUserId) VALUES (?, ?)");
        $reportSql->bind_param("ii", $repUserId, $userId);
        $reportSql->execute();
        $reportSql->close();

        $response['error'] = 0;
        $response['msg'] = "Obrigado Por Sua Denúncia!";
    } elseif($checkRes->num_rows > 0) {
        $response['error'] = 0;
        $response['msg'] = "Você já denunciou este Perfil";
    }
        
    $response = json_encode($response);
    echo $response;

?>