<?php

if(!isset($_SESSION['userId'])){
    $userId = 0;
} else {
    $userId = $_SESSION['userId'];
}

while($row = $result->fetch_assoc()){
    $postId = $row['postId'];
    $postUserId = $row['postUserId'];
    $postUserName = $row['postUserName'];
    $postUserPic = $row['postUserPicture'];
    $postUserAccess = $row['postUserAccess'];
    $postTxt = $row['postTxt'];
    $postImg = $row['postImg'];
    $postVideo = $row['postVideo'];
    $postDate = $row['postDate'];

    $sqlComm = "SELECT u.userName, u.userPicture, u.userId, u.userAccess, c.commentId, c.commentTxt, DATE_FORMAT(c.commentDate, '%H:%i <br> %d/%m/%Y') AS commentDate 
    FROM postComments AS c INNER JOIN logins AS u ON c.commentUserId = u.userId WHERE c.commentPostId={$postId} AND c.commentStatus='on' ORDER BY commentId ASC";
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
    
    $totComm = "SELECT COUNT(commentId) FROM postComments WHERE commentPostId={$postId} AND commentStatus='on'";
    $totCommRes = $conn->query($totComm);

    $rowTC = $totCommRes->fetch_all(MYSQLI_NUM);

    $postTotComm = numerin($rowTC[0][0]);

    $sqlLike = "SELECT IF((COUNT(likeId)) > 0, '../media/default/fullLike.png', 
    '../media/default/emptyLike.png') AS postLikeImg FROM postLikes WHERE likePostId={$postId} AND likeUserId={$userId}";
    $resultL = $conn->query($sqlLike);

    while($rowL = $resultL->fetch_assoc()){
        $postLike = $rowL['postLikeImg'];
    }

    $resultL->close();

    $sqlTotL = "SELECT COUNT(likeId) as totLike FROM postLikes WHERE likePostId={$postId}";
    $resultTotL = $conn->query($sqlTotL);

    while($rowTotL = $resultTotL->fetch_assoc()){
        $postTotLike = $rowTotL['totLike'];
    }
    $resultTotL->close();

    ob_start();
        include "../templates/post.php";
    $posts .= ob_get_clean();
}

$posts .= '<!-- feedAd -->
        <div>
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-4730683918390440"
                 data-ad-slot="9880470937"
                 data-ad-format="auto"
                 data-full-width-responsive="true"></ins>
            <script>
                 (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>';

?>