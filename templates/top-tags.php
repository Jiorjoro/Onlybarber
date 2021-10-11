<?php

require "../php/dbconn.php";

$sqlTag = "SELECT tagTxt FROM rankRecTags LIMIT 3";
$rawResult = $conn->query($sqlTag);

$result = $rawResult->fetch_all(MYSQLI_NUM);

?>

<div class="hashs">
    <h3>Tags em Alta</h3>
    <form action="busca.php" method="post">
        <input type="hidden" name="scope" value="tag">
        <input type="submit" name="search" value="<?php echo $result[0][0]; ?>">
    </form>
    <form action="busca.php" method="post">
        <input type="hidden" name="scope" value="tag">
        <input type="submit" name="search" value="<?php echo $result[1][0]; ?>">
    </form>
    <form action="busca.php" method="post">
        <input type="hidden" name="scope" value="tag">
        <input type="submit" name="search" value="<?php echo $result[2][0]; ?>">
    </form>
</div>