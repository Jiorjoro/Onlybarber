<header>
    <a href="login.php">
        <img src="../media/default/logo.png" alt="Logo" class="logo">
    </a>
    
        <div class="logo"><a href="login.php">ONLYBARBER</a></div>
    
    <form action="busca.php" method="post">
        <select name="scope">
            <option value="user">Pessoas</option>
            <option value="tag">Tags</option>
            <option value="content">Conteúdo</option>
        </select>
        <input type="search" placeholder="Pesquisar" name="search">
        <input type="submit" value="Buscar">
    </form>
    <?php

    if(!isset($_SESSION['userId']) || empty($_SESSION['userId'])){
    
        echo "
        <a href='login.php'>
            <div class='user-nolog'>
                Logar
            </div>
        </a>";
        
    } else{
    
        echo '<div class="user">
                <img src="'.$_SESSION['userPicture'].'" alt="User-Pic">
                <i id="notify" class="feather-bell"></i>
                <div>
                    <a href="../pages/perfil.php?pU='.$_SESSION['userId'].'">
                        <i class="feather-user">
                            Perfil
                        </i>
                    </a>
                    <a href="javascript:void(0);" onclick="openMainNotify()">
                        <i class="feather-bell">
                            Notificações
                        </i>
                    </a>
                    <a href="../pages/userConfigPanel.php">
                        <i class="feather-settings">
                            Configurações
                        </i>
                    </a>                
                    <hr>
                    <a href="../php/logout.php">
                        <i class="feather-log-out">
                            Sair
                        </i>
                    </a>
                </div>
            </div>';
    }
    ?>
</header>