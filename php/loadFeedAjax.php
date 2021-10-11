<?php

    session_start();

    if(!isset($_SESSION['userId'])){
        $userId = 0;
    } else {
        $userId = $_SESSION['userId'];
    }

    $data = json_decode($_POST['data']);
    $action = $data->action;
    $lastId = $data->lastPostId;
    $toSend = [];

    if($lastId == 1){
        $toSend['posts'] = '';
        $toSend['lastPostId'] = 1;
        $toSend = json_encode($toSend);
        echo $toSend;
        exit();
    }

    require "dbconn.php";
    require "functions.php";

    if($lastId == 0){
        $getId = "SELECT postId FROM posts ORDER BY postId DESC LIMIT 1";
        $rawId = $conn->query($getId);
        while($row = $rawId->fetch_assoc()){
            $lastId = $row['postId'] + 1;
        }
        $rawId->close();
    }

    switch($action){
        case 'all':

            $sql = $conn->prepare("SELECT * FROM donePost WHERE postId<? LIMIT 5");
            $sql->bind_param('i', $lastId);
            $sql->execute();
            $result = $sql->get_result();

            break;
        case 'follow':

            $sql = $conn->prepare("SELECT u.userName AS postUserName, u.userPicture AS postUserPicture, u.userId AS postUserId, u.userAccess AS postUserAccess, 
            p.postId, p.postTxt, p.postImg, p.postVideo, DATE_FORMAT(p.postDate, '%H:%i <br> %d/%m/%Y') AS postDate 
            FROM posts AS p INNER JOIN logins AS u ON p.postUserId = u.userId 
            INNER JOIN follows AS f ON f.followedId = p.postUserId 
            WHERE f.followerId=? AND p.postId<? AND postStatus='on' ORDER BY p.postId DESC LIMIT 5");
            $sql->bind_param('ii', $_SESSION['userId'], $lastId);
            $sql->execute();
            $result = $sql->get_result();

            break;
        case 'search':

            $search = $_SESSION['search'];
			$scope =  $_SESSION['scope'];

            if($scope == 'tag'){
                
                $sql = $conn->prepare("SELECT u.userName AS postUserName, u.userPicture AS postUserPicture, u.userId AS postUserId, u.userAccess AS postUserAccess, 
                p.postId, p.postTxt, p.postImg, p.postVideo, DATE_FORMAT(p.postDate, '%H:%i <br> %d/%m/%Y') AS postDate 
                FROM posts AS p INNER JOIN logins AS u ON p.postUserId = u.userId INNER JOIN postTags AS t ON p.postId = t.tagPostId  
                WHERE (t.tagTxt LIKE CONCAT('%', ?,'%')) AND p.postId<? AND p.postStatus='on' ORDER BY p.postId DESC LIMIT 5");
                $sql->bind_param('si', $search, $lastId);
                $sql->execute();
                $result = $sql->get_result();

            } elseif($scope == 'content'){

                $sql = $conn->prepare("SELECT * FROM donePost WHERE (postTxt LIKE CONCAT('%', ?,'%')) AND postId<? LIMIT 5");
                $sql->bind_param('si', $search, $lastId);
                $sql->execute();
                $result = $sql->get_result();

            } elseif($scope == 'user'){
                $toSend['posts'] = "";
                $toSend['lastPostId'] = 0;
                $toSend = json_encode($toSend);
                echo $toSend;
                exit();
            }

            break;
        case 'prof':

            $profUserId = $_SESSION['profUserId'];

            $sql = $conn->prepare("SELECT * FROM donePost WHERE postUserId=? AND postId<? LIMIT 5");
            $sql->bind_param('ii', $profUserId, $lastId);
            $sql->execute();
            $result = $sql->get_result();

            break;
    }
    
    $posts = "";

    if($result->num_rows == 0){
        if($action == 'search'){
            $toSend['posts'] = "<h2>Sem Resultados</h2>";
            $toSend['lastPostId'] = 1;
            $toSend = json_encode($toSend);
            echo $toSend;
            exit();
        } elseif($action == 'share'){
            $toSend['posts'] = "<h2>Nenhuma Postagem Encontrada</h2>";
            $toSend['lastPostId'] = 1;
            $toSend = json_encode($toSend);
            echo $toSend;
            exit();
        }
    }

    if($result->num_rows > 0){
        require "loadPosts.php";
    } else {
        $postId = 1;
    }

    $toSend['posts'] = $posts;
    $toSend['lastPostId'] = $postId;
    $toSend = json_encode($toSend);
    echo $toSend;

    $sql->close();
    $conn->close();

?>