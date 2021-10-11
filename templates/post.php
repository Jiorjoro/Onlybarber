<div id="post<?php echo $postId; ?>" class="post" tabindex="0">
    <div class="post-head">
        <a href="../pages/perfil.php?pU=<?php echo $postUserId; ?>">
            <img src="<?php echo $postUserPic; ?>" alt="Imagem-Perfil">
            <div class="nome">
                <?php echo $postUserName; ?>
            </div>
            <?php
                if($postUserAccess == 'verified'){
                    echo "<i class='feather-check'></i>";
                }
            ?>
        </a>
        <div class="date">
            <?php echo $postDate; ?>
        </div>
    </div>
    <div class="post-body">
        <?php
            
            if(!empty($postImg)){    
                echo "<img src='$postImg' alt='Post-Image'>";
            }
            if(!empty($postVideo)){    
                echo "<video src='$postVideo' alt='Post-Image'controls></video>";
            }
            
            if(!empty($postTxt)){
                echo "<div class='texto'>
                        $postTxt
                    </div>";
            }
        ?>
    </div>
    <div class="post-reactions">
        <div class="like">
            <img onclick="likePost(this, <?php echo $postId; ?>)" src="<?php echo $postLike; ?>">
            <span><?php echo $postTotLike; ?></span>     
        </div>
        <i onclick="showComments(<?php echo $postId; ?>)" class="feather-message-square"><span><?php echo $postTotComm; ?></span></i>
        <i onclick="sharePost(<?php echo $postId; ?>)" class="feather-share-2"></i>
        <div class="feather-plus">
            <div class="post-more">
                <?php               
                    if($userId == $postUserId){                     
                        echo "<div onclick=\"deletePost({$postId}, {$postUserId})\">Excluir</div>";
                    }
                ?>
                <div onclick="reportPost(<?php echo $postId; ?>)" >Denunciar</div>
            </div>
        </div>
    </div>
    <div id="postComm<?php echo $postId; ?>" class="post-comments hidden">
        <?php echo $postComments; ?>
    </div>
    <form onsubmit="sendPostComment(this, <?php echo $postId; ?>)" method="post" class="hidden">
        <input type="text" name="userComment">
        <input type="submit" value="Comentar">
    </form>
</div>