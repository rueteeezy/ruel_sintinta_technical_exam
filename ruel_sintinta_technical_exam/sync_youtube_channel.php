<?php
include 'show_youtube_channel.php';

$myChannelID = $_POST["channel"]; 

$myApiKey="AIzaSyC74A_XuBmfu0NwYOyUpRBE-qyeBWpxFqQ";



saveVideoDetails($myChannelID,$myApiKey);

function saveVideoDetails($myChannelID,$myApiKey) {

    
$servername = "localhost";
$username = "root";
$password = "admin";
$dbname = "youtube_app";
$conn = new mysqli($servername, $username, $password, $dbname);   

    $url = "https://www.googleapis.com/youtube/v3/channels?part=snippet&fields=items%2Fsnippet%2Fthumbnails%2Fdefault&id=$myChannelID&key=$myApiKey";

    $ch = curl_init();
    curl_setopt( $ch, CURLOPT_URL, $url );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $channelOBJ = json_decode( curl_exec( $ch ) );
    
    $thumbnail_url = $channelOBJ->items[0]->snippet->thumbnails->default->url;

    $picOne = str_replace("https://","",$thumbnail_url);

    $sqlOne = "INSERT INTO youtube_channels (profile_picture)
    VALUES ($picOne)"; 

if ($conn->query($sqlOne) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sqlOne . "<br>" . $conn->error;
}

$myQuery = "https://www.googleapis.com/youtube/v3/search?key=$myApiKey&channelId=$myChannelID&part=snippet,id&order=date&maxResults=50";
$videoList = file_get_contents($myQuery);
 
$decoded = json_decode($videoList, true);
 
foreach ($decoded['items'] as $items)
{
$title= $items['snippet']['title'];
$thumbnail = $items['snippet']['thumbnails']['default']['url'];

$pic = str_replace("https://","",$thumbnail);

$sql = "INSERT INTO youtube_channel_videos (thumbnails,video_titles)
VALUES ($pic,$title)";

echo "
<p style='display:inline-block;width:200px;margin:10px;text-align:center;vertical-align:top'>";
echo "<img src='$thumbnail'> 
";
echo "<strong>$title</strong>
";
echo "";
}
    
}


?>