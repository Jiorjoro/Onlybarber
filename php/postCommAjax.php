<?php 

    session_start();

    $response = [];
    
    if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])){
        $response['error'] = 1;
        $response['comms'] = "";
        $response['totComms'] = "";
        $response = json_encode($response);
        echo $response;
        exit();
    }

    require "functions.php";
    require "dbconn.php";

    $postId = qBoa($_POST['postId']);
    $postId = $conn->real_escape_string($postId);
    $userComm = qBoa($_POST['userComm']);
    $userId = $_SESSION['userId'];

    if(strlen($userComm) <= 0){
        $response['error'] = 0;
        $response['comms'] = "";
        $response['totComms'] = "";
        $response = json_encode($response);
        echo $response;
        exit();
    }

    $insert = $conn->prepare("INSERT INTO postComments (commentPostId, commentUserId, commentTxt) VALUES (?, ?, ?)");
    $insert->bind_param('iis', $postId, $_SESSION['userId'], $userComm);
    $insert->execute();
    $commId = $insert->insert_id;
    $insert->close();

    $piece = explode(' ', $userComm);
    foreach($piece as $tok){
        if(strpos($tok, "@") == 0){
            $name = str_replace('@', '', $tok);
                
                $addNotify = $conn->prepare("SELECT userId FROM logins WHERE userName=?;");
                $addNotify->bind_param('s', $name);
                $addNotify->execute();
                $notifyRes = $addNotify->get_result();
                $addNotify->close();
                
                if($notifyRes->num_rows > 0){
                    while($rowNtf = $notifyRes->fetch_assoc()){
                        $notifyUser = $rowNtf['userId'];
                    }

                    $userComm = str_replace('@'.$name, '<a href="../pages/perfil.php?pU='.$notifyUser.'">@'.$name.'</a>', $userComm);

                    $notfLink = "http://localhost:8080/onlibar/pages/sharePost.php?postId=".$postId;
                    $notfTxt = "Alguém te marcou em uma postagem!";

                    $sendNotify = "INSERT INTO notifications (notificationUserId, notificationLink, notificationTxt) 
                    VALUES ('{$notifyUser}', '{$notfLink}', '{$notfTxt}')";
                    $conn->query($sendNotify);

                    $changePost = "UPDATE postComments SET commentTxt='{$userComm}' WHERE commentId='{$commId}'";
                    $conn->query($changePost);
                }
        }
    }

    $sqlComm = "SELECT u.userName, u.userPicture, u.userId, u.userAccess, c.commentId, c.commentTxt, DATE_FORMAT(c.commentDate, '%H:%i <br> %d/%m/%Y') AS commentDate 
    FROM `postcomments` AS c INNER JOIN logins AS u ON c.commentUserId = u.userId WHERE c.commentPostId={$postId} AND c.commentStatus='on'  ORDER BY c.commentId ASC";
    $resultC = $conn->query($sqlComm);
    $postComments = "";

    while($rowC = $resultC->fetch_assoc()){
        $commentId = $rowC['commentId'];
        $commentUserId = $rowC['userId'];
        $commentUserName = $rowC['userName'];
        $commentUserPicture = $rowC['userPicture'];
        $commentUserAccess = $rowC['userAccess'];
        $commentTxt = $rowC['commentTxt'];
        $commentDate = $rowC['commentDate'];

        ob_start();
            include "../templates/postComment.php";
        $postComments .= ob_get_clean();

    }

    $resultC->close();

    $totComm = "SELECT COUNT(commentId) AS totComm FROM postComments WHERE commentPostId={$postId} AND commentStatus='on'";
    $totComm = $conn->query($totComm);
    $rowTotC = $totComm->fetch_all(MYSQLI_NUM);
    $postTotComms = $rowTotC[0][0];

    $getPU = $conn->prepare("SELECT postUserId from posts WHERE postId=?");
    $getPU->bind_param('i', $postId);
    $getPU->execute();
    $PU = $getPU->get_result();
    $getPU->close();
    $rowPU = $PU->fetch_all(MYSQLI_NUM);
    $postUserId = $rowPU[0][0];
    $notfLink = "http://localhost:8080/onlibar/pages/sharePost.php?postId=".$postId;
    $notfTxt = "Alguém comentou sua postagem!";

    $notify = $conn->prepare("INSERT INTO notifications (notificationUserId, notificationLink, notificationTxt) VALUES (?, ?, ?);");
    $notify->bind_param('iss', $postUserId, $notfLink, $notfTxt);
    $notify->execute();
    $notify->close();

    $response['error'] = 0;
    $response['comms'] = $postComments;
    $response['totComms'] = numerin($postTotComms);
    $response = json_encode($response);
    echo $response;
    exit();

?>
