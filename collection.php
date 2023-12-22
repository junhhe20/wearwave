<?php
    $host = "18.144.174.141";
    $user = "wearwave";
    $pass = "WRfca6HxRnL7kGZH";
    $db = "wearwave";

    $mysqli = new mysqli($host, $user, $pass, $db);

    $mysqli->set_charset("utf8mb4");

    //check for mysql connection errors 
    if($mysqli->connect_errno){
    echo $mysqli->connect_error;
    exit();
    }

    $sql = "SELECT * FROM Outfit;";
    $results = $mysqli->query($sql);
    if (!$results) {
        echo $mysqli->error;
        exit();
    }
    $mysqli->close();

?>

<!DOCTYPE html>

<html lang = "en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wear Wave</title>
    <meta name="description" content="Discover the Collection page on Wear Wave, showcasing a curated selection of user-uploaded fashion outfits. Browse through diverse styles, soundtracks, and find inspiration for your next fashion statement. Join the trendsetters!">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="collection.css">
</head>
<body>

    <div id = "navbar">
        <a href="home.php">GALLERY</a>
        <a href="upload.php">MONTAGE</a>
        <a href="collection.php">COLLECTION</a>
    </div>


    <div class="container mt-4">
        <div class="row" id="postsContainer">
            <?php 
            while($row = $results->fetch_assoc()) {
                echo "<div class='col-md-4 mb-5'>";
                echo "<div class='card'>";
                echo "<div class='img'><img class='card-img-top' src='" . $row['ImageURL'] . "' alt='Outfit Image'></div>";
                echo "<div class='card-body'></div>";
                echo "<a href='edit_outfit.php?id=" . $row['OutfitID'] . "' class='btn'>Edit</a> ";
                echo "<a href='delete_outfit.php?id=" . $row['OutfitID'] . "' class='btn' onclick='return confirm(\"Are you sure you want to delete this?\")'>Delete</a>";
                echo "</div></div>";
            }

            ?>

        </div>       
    </div>
    

</body>
</html>