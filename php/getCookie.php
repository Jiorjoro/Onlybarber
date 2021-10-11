<?php

    if(!isset($_SESSION['userId']) || !isset($_SESSION['userPicture'])){

        if(isset($_COOKIE['userId']) || isset($_COOKIE['userId']) 
        || !empty($_COOKIE['userId']) || !empty($_COOKIE['userPicture'])){
            
            $_SESSION['userId'] = $_COOKIE['userId'];
            $_SESSION['userPicture'] = $_COOKIE['userPicture'];
        }

    }

?>