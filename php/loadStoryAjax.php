<?php

    session_start();

    require "functions.php";
    require "dbconn.php";

    $storyUserId = qBoa($_POST['storyUserId']);
    $userId = $_SESSION['userId'];

    $sql = "SELECT u.userName, u.userPicture, u.userAccess, s.storyId, s.storyImg, s.storyVideo 
    FROM logins AS u INNER JOIN stories AS s ON u.userId=s.storyUserId 
    WHERE u.userId='{$storyUserId}' AND s.storyStatus='on' 
    AND s.storyDate >= (DATE(NOW()) - INTERVAL 1 DAY)";
    $result = $conn->query($sql);
    $stories = '<i class="feather-x" onclick="closeStory()"></i>';

    $contador = 1;
    while($row = $result->fetch_assoc()){
        $storyId = $row['storyId'];
        $storyUserName = $row['userName'];
        $storyUserPic = $row['userPicture'];
        $storyUserAccess = $row['userAccess'];
        $storyImg = $row['storyImg'];
        $storyVideo = $row['storyVideo'];
        
            $storyClass = " hidden";
        

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

        $sqlLike = "SELECT IF((COUNT(likeId)) > 0, '../media/default/fullLike.png', 
        '../media/default/emptyLike.png') AS storyLikeImg FROM storyLikes WHERE likeStoryId={$storyId} AND likeUserId={$userId}";
        $resultL = $conn->query($sqlLike);
    
        while($rowL = $resultL->fetch_assoc()){
            $storyLike = $rowL['storyLikeImg'];
        }
    
        $resultL->close();
    
        $sqlTotL = "SELECT COUNT(likeId) as totLike FROM storyLikes WHERE likeStoryId={$storyId}";
        $resultTotL = $conn->query($sqlTotL);
    
        while($rowTotL = $resultTotL->fetch_assoc()){
            $storyTotLike = $rowTotL['totLike'];
        }
        $resultTotL->close();

        ob_start();
            include "../templates/story.php";
        $stories .= ob_get_clean();
    }

    $conn->close();

    echo $stories;
?>