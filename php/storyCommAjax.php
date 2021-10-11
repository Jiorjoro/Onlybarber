<?php 

    session_start();

    $response = [];
    
    if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])){
        $response['error'] = 1;
        $response['comms'] = "";
        $response = json_encode($response);
        echo $response;
        exit();
    }

    require "functions.php";
    require "dbconn.php";

    $storyId = qBoa($_POST['storyId']);
    $storyId = $conn->real_escape_string($storyId);
    $userComm = qBoa($_POST['userComm']);
    $userId = $_SESSION['userId'];

    $insert = $conn->prepare("INSERT INTO storyComments (commentStoryId, commentUserId, commentTxt) VALUES (?, ?, ?)");
    $insert->bind_param('iis', $storyId, $_SESSION['userId'], $userComm);
    $insert->execute();
    $insert->close();

    $sqlComm = "SELECT u.userId, u.userName, u.userAccess, c.commentId, c.commentTxt 
    FROM storyComments AS c INNER JOIN logins AS u ON c.commentUserId = u.userId 
    WHERE c.commentStoryId='{$storyId}' AND c.commentStatus='on' ORDER BY c.commentId ASC";
    $resultC = $conn->query($sqlComm);
    $storyComments = "";

    while($rowC = $resultC->fetch_assoc()){
        $commentId = $rowC['commentId'];
        $commentUserId = $rowC['userId'];
        $commentUserName = $rowC['userName'];
        $commentUserAccess = $rowC['userAccess'];
        $commentTxt = $rowC['commentTxt'];
        
        ob_start();
            include "../templates/storyComment.php";
        $storyComments .= ob_get_clean();

    }
    $resultC->close();

    $response['error'] = 0;
    $response['comms'] = $storyComments;
    $response = json_encode($response);
    echo $response;
    exit();

?>
