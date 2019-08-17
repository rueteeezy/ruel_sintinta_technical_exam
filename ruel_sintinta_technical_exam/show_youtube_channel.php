
<center>
<form action="sync_youtube_channel.php" method="post">
    <p><input type="text" name="channel" placeholder="Enter Channel ID" value="<?php if(array_key_exists('channel', $_GET)) echo $_GET['channel']; ?>" required></p>
    <p><input type="submit" value="Submit"></p>
</form>
</center>

