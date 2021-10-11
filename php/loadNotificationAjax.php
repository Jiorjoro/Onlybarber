<?php 

    session_start();

    require "../php/dbconn.php";

    $sql = "SELECT * FROM notifications WHERE notificationUserId={$_SESSION['userId']} AND notificationDate >= (DATE(NOW()) - INTERVAL 1 WEEK)";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $notfLink = $row['notificationLink'];
            $notfTxt = $row['notificationTxt'];

            echo "<a href='{$notfLink}'><div class='notification'>{$notfTxt}</div></a>";
        }
    } else {
        echo "<p>Nada Por Enquanto</p>";
    }

    $result->close();
    $conn->close();

    exit();
?>