<?php
if (isset($_POST['emoji']) && isset($_POST['attire'])) {
    $host = "18.144.174.141";
    $user = "wearwave";
    $pass = "WRfca6HxRnL7kGZH";
    $db = "wearwave";
    
    $mysqli = new mysqli($host, $user, $pass, $db);

    if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
    }

    $mysqli->set_charset("utf8mb4");

   
    //making sure that the image exists and no errors during the upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Define target directory for file upload
        $target_dir = "img/"; 
        // concatenate the target directory with the basename of the uploaded file
        // basename() function gets the filename from the file path
        $target_file = $target_dir . basename($_FILES['image']['name']);
            
        // move the uploaded file from the temporary directory to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $imageUrl = $target_file; 
        } else {
            echo "Error uploading file.";
            exit();
        }
    } else {
        echo "File upload error.";
        exit();
    }

    $soundtrackURL = isset($_COOKIE['soundtrackURL']) ? $_COOKIE['soundtrackURL'] : null;
    $emojiId = $_POST['emoji'];
    $attireId = $_POST['attire'];
    $spotlight = $_POST['spotlight'];
    $details = $_POST['details'];

    $sql = "INSERT INTO Outfit (ImageURL, SoundtrackURL, SpotlightItem, Details, PostDate, EmojiID, AttireID) VALUES ('$imageUrl', '$soundtrackURL', '$spotlight', '$details', CURDATE(), '$emojiId', ' $attireId')";

    $result = $mysqli->query($sql);
    if(!$result){
        echo $mysqli->error;
        $mysqli->close();
        exit();
    }else {
        header("Location: home.php");
        exit();
    }
    setcookie('soundtrackURL', '', time() - 3600, '/');

    $mysqli->close();

}
?>

