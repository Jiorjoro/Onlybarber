<div class="comment" id="comm<?php echo $commentId; ?>">
    <div class="comment-head">
        <?php echo $commentUserName; ?>
        <?php
            if($commentUserAccess == 'verified'){
                echo "<i class='feather-check'></i>";
            }
        ?>
    </div>
    <?php
        if($commentUserId == $userId){
            echo "<i class='feather-trash-2' onclick='deleteComment({$commentId}, {$commentUserId})'></i>";
        }
    ?>
    <br>
    <div class="txt">
        <?php echo $commentTxt; ?>
    </div>
</div>