<form class="creatPost" action="../php/creatpost.php" method="post" enctype="multipart/form-data">
    <textarea name="postTxt" max-length="200" placeholder="O que está pensando?"></textarea>
    <input type='hidden' name='MAX_FILE_SIZE' value='50000000' />
    <div>
        <label for="postUpload">
            <i class="feather-paperclip"></i>Escolha um arquivo
        </label>
        <input type="file" name="postUpload" id="postUpload" accept="image/*">
        <input type="submit" name="submit" value="Postar">
    </div>
</form>
if(isset($_SESSION['userId'])){
    include "../templates/new-post.php";
}