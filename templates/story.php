<div class="story<?php echo $storyClass; ?>" id="story<?php echo $storyId; ?>">
    <div class="story-head">
        <img src="<?php echo $storyUserPic; ?>" alt="Imagem-Perfil">
        <div class="nome">
            <?php echo $storyUserName; ?>
        </div>
        <?php
            if($storyUserAccess == 'verified'){
                echo "<i class='feather-check'></i>";
            }
        ?>
        <div class="feather-plus">
            <div class="post-more">
                <?php               
                    if($userId == $storyUserId){                     
                        echo "<div onclick=\"deleteStory({$storyId}, {$storyUserId})\">Excluir</div>";
                    }
                ?>
                <div onclick="reportStory(<?php echo $storyId; ?>)" >Denunciar</div>
            </div>
        </div>
    </div>
    <div class="story-media">
        <i class="feather-chevron-left" onclick="changeStory(-1)"></i>
        <i class="feather-chevron-right" onclick="changeStory(1)"></i>
        <?php
            if(!empty($storyImg)){    
                echo "<img src='$storyImg'>";
            }
            if(!empty($storyVideo)){    
                echo "<video src='$storyVideo' controls></video>";
            }
        ?>
    </div>
    <div class="story-reactions">
        <div class="like">
            <img onclick="likeStory(this, <?php echo $storyId; ?>)" src="<?php echo $storyLike; ?>">
            <span><?php echo $storyTotLike; ?></span>     
        </div>
        <i class="feather-message-square" onclick="toggleComm(<?php echo $storyId; ?>)"></i>
    </div>
    <div class="story-comments hidden">
        <?php echo $storyComments; ?>
    </div>
    <form class="new-comm hidden" onsubmit="sendStoryComment(this, <?php echo $storyId; ?>)" method="POST" autocomplete="off">
        <input type="text" name="userComm" onfocus="window.removeEventListener('keydown', storyArrows);" onfocusout="window.addEventListener('keydown', storyArrows);">
        <input type="submit" value="Comentar">
    </form>
</div>