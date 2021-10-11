<div class="comment">
    <div class="comment-head">
        <a href="../pages/perfil.php?pU=<?php echo $commentUserId; ?>">
            <img src="<?php echo $commentUserPicture; ?>" alt="Imagem-Perfil">
            <div class="nome">
                <?php echo $commentUserName; ?>
            </div>
            <?php
                if($commentUserAccess == 'verified'){
                    echo "<i class='feather-check'></i>";
                }
            ?>
        </a>
        <div class="date">
            <?php echo $commentDate; ?>
        </div>
    </div>
    <?php
        if($commentUserId == $userId){
            echo "<i class='feather-trash-2' onclick='deleteComment({$commentId}, {$commentUserId})'></i>";
        }
    ?>
    <div class="texto">
        <?php echo $commentTxt; ?>
    </div>    
</div>