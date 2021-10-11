<?php
    
    session_start();
			
    // deleta a sessão
    session_unset();
    session_destroy();
    
    //deleta os cookies
    if(isset($_COOKIE['userId']) || isset($_COOKIE['userPicture'])){
        setcookie('userId', '', time() - (86400 * 9), "/");
        setcookie('userPicture', '', time() - (86400 * 9), "/");
        unset($_COOKIE['userId']);
        unset($_COOKIE['userPicture']);
    }
    
    header("Location: ../pages/login.php", 301);

?>