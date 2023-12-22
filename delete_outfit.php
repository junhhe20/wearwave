<?php
$host = "18.144.174.141";
$user = "wearwave";
$pass = "WRfca6HxRnL7kGZH";
$db = "wearwave";

$mysqli = new mysqli($host, $user, $pass, $db);

$mysqli->set_charset("utf8mb4");

if($mysqli->connect_errno){
echo $mysqli->connect_error;
exit();
}

// Get ID from URL
$outfitId = $_GET['id'];

$sql = "DELETE FROM Outfit WHERE OutfitID = $outfitId";

if (!$mysqli->query($sql)) {
    echo "Error deleting record: " . $mysqli->error;
}

$mysqli->close();

header("Location: collection.php");
exit();
?>
