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

    $sql = "SELECT ImageURL, SoundtrackURL, SpotlightItem, Details, PostDate, Emojis.Emoji, Attires.AttireType 
            FROM Outfit
            LEFT JOIN Emojis ON Outfit.EmojiID = Emojis.EmojiID
            LEFT JOIN Attires ON Outfit.AttireID = Attires.AttireID;";
            
    $results = $mysqli->query($sql);
    if (!$results) {
        echo "SQL Error: " . $mysqli->error;
        exit();
    }

    // Close the connection
    $mysqli->close();

?>


<!DOCTYPE html>

<html lang = "en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wear Wave</title>
    <meta name="description" content="Explore the Gallery at Wear Wave, a visual feast of fashion and music. Dive into a world where style meets sound, and discover an array of outfits paired with their unique soundtracks. Join our community and get inspired!">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id = "navbar">
        <a href="home.php">GALLERY</a>
        <a href="upload.php">MONTAGE</a>
        <a href="collection.php">COLLECTION</a>
    </div>
            <div class="container">
                <?php 
                while($row = $results->fetch_assoc()) {
                    echo "<div class='rectangle'>";
    
                    echo "<div class='img'><img class='image' src='" . $row['ImageURL'] . "' alt='outfit'>";
                    echo "<div class='arrow'>&#9654;</div></div>";
    
                    echo "<div class='description'>";
                    $postDate = date("F j, Y", strtotime($row['PostDate']));
                    echo "<div class='post-date'>" . $postDate . "</div>"; 
                    if(!empty($row['SoundtrackURL'])) {
                        echo "<div class='song'><span class='label'>Jamming to: </span><audio controls src='" . $row['SoundtrackURL'] . "'></audio></div>";
                    }
                    else{
                        echo "<div class='song'><span class='label'>Jamming to: Silent Mode</span></div>";
                    }
                    if(!empty($row['Emoji'])) {
                        echo "<div class='emoji'><span class='label'>Mood: </span>" . $row['Emoji'] . "</div>";
                    }
                    if(!empty($row['AttireType'])) {
                        echo "<div class='key-piece'><span class='label'>Attire: </span>" . $row['AttireType'] . "</div>";
                    }
                    if(!empty($row['SpotlightItem'])) {
                        echo "<div class='details'><span class='label'>Rockstar Item: </span>" . $row['SpotlightItem'] . "</div>";
                    }
                    if(!empty($row['Details'])) {
                        echo "<div class='details'><span class='label'>Fashion Deets: </span>" . $row['Details'] . "</div>";
                    }
                    echo "</div></div>";
                }
                ?>
            </div>
            
           
            <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>


        <script>
        document.querySelectorAll('.arrow').forEach(arrow => {
            arrow.addEventListener('click', () => {
                const descriptionDiv = arrow.parentElement.nextElementSibling;
                descriptionDiv.classList.toggle('show-description');
            });
        });
        </script>






</body>
</html>