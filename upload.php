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

    $sql_emojis = "SELECT * FROM Emojis;";
	$results_emojis = $mysqli->query($sql_emojis);
	if ( $results_emojis == false ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}

    $sql_attires = "SELECT * FROM Attires;";
	$results_attires = $mysqli->query($sql_attires);
	if ( $results_attires == false ) {
		echo $mysqli->error;
		$mysqli->close();
		exit();
	}
    $mysqli->set_charset('utf8'); 


?>

<!DOCTYPE html>

<html lang = "en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Wear Wave</title>
    <meta name="description" content="Create your fashion montage on Wear Wave's Montage page. Upload your outfit, select a soundtrack, and share your style with the world. It's where your fashion sense meets your music taste. Unleash your creativity now!">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id = "navbar">
        <a href="home.php">GALLERY</a>
        <a href="upload.php">MONTAGE</a>
        <a href="collection.php">COLLECTION</a>
    </div>


    <div class = "container">


        <div class="row justify-content-center m-2">
            <form id="add-button" method="POST" action="submit_outfit.php" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="mb-4">
                        <label for="sound" class="col-form-label">Give your outfit a soundtrack! (Song name and artist name)</label>
                        <input type="text" name="sound" class="form-control" placeholder="despacito" id="sound" required>
                        <small id="sound-error" class="form-text text-danger"></small>
                    </div>  

                    <div class="mb-4">
                        <label for="emoji" class="col-form-label">What mood does your outfit represent? Share with an emoji!</label>
                        <select name="emoji" class="form-control" id="emoji" required>

                        <option value="" selected disabled>-- Select One --</option>

                        <?php
                            while($row = $results_emojis->fetch_assoc()) : ?>
                            <option value='<?php echo $row["EmojiID"]; ?>'>
                                <?php echo $row["Emoji"]; ?>
                            
                        <?php endwhile; ?>
                        </select>
                        <small id="emoji-error" class="form-text text-danger"></small>
                    </div>

                    <div class="mb-4">
                        <label for="attire" class="col-form-label">What's your outfit's style today? Choose an attire type!</label>
                        <select name="attire" class="form-control" id="attire" required>
                        <option value="" selected disabled>-- Select One --</option>

                        <?php
                            while($row = $results_attires->fetch_assoc()) : ?>
                            <option value='<?php echo $row["AttireID"]; ?>'>
                                <?php echo $row["AttireType"]; ?>
                            
                        <?php endwhile; ?>    
                      
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="spotlight" class="col-form-label">What's the key piece in your look today that deserves a round of applause?</label>
                        <input type="text" name="spotlight" class="form-control" placeholder="leather jacket" id="spotlight">
                        <small id="spotlight-error" class="form-text text-danger"></small>
                    </div>

                    <div class="mb-4">
                        <label for="imageUpload" class="col-form-label">Let's see what you're cooking today :)</label>
                        <input type="file" name="image" class="form-control" id="imageUpload" accept="image/*" required>
                        <small id="image-error" class="form-text text-danger"></small>
                    </div>
                    
                    <div class="mb-4">
                        <label for="details" class="col-form-label">Any additional details you want to share?</label>
                        <textarea name="details" class="form-control" placeholder="top from zara, pants from lululemon, and shoes from converse" id="details" rows="4"></textarea>
                        <small id="details-error" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary" style="background-color: rgb(144, 107, 107); border: none;" id="addOotdBtn">ADD OOTD</button>
                        </div> 
                    </div> 
                    </div>  
                </form>
            </div>
    </div>
 

    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>

        function fetchSoundtrack() {
            document.cookie = 'soundtrackURL=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
            const sound = document.querySelector("#sound").value.trim();
            if(sound){
                const endpoint = "https://itunes.apple.com/search?term=" + sound + "&limit=1"; 

                $.ajax({
                url: endpoint,
                dataType: "json",
                success: function(result) {
                    if(result.resultCount > 0) {
                        document.cookie = "soundtrackURL=" + encodeURIComponent(result.results[0].previewUrl) + ";path=/";
                        console.log("Soundtrack URL: ", soundtrackUrl);
                        
                    } 
                    else {
                        console.log("No results found.");
                    }
                    },
                    error: function() {
                        console.log("Error in AJAX request.");
                    }
                });
            }
        }

        $(document).ready(function() {
            $('#sound').on('input', fetchSoundtrack);
            document.querySelector("#sound").value = '';
        });

                
    </script>




</body>
</html>