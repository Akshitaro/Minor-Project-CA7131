<?php

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "travelscapes";  


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$cityId = $_GET['city_id']; 


$sql = "SELECT * FROM cities WHERE cityid = $cityId";
$result = $conn->query($sql);



$folderPath = './Places/';
$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
$imageArray = array();


$files = scandir($folderPath);

foreach ($files as $file) {
    $fileInfo = pathinfo($file);
    $extension = strtolower($fileInfo['extension']);

    if (in_array($extension, $allowedExtensions)) {
        
        $imageArray[] = $folderPath . $file;
    }
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $city = $row['city'];
    $region = $row['region'];
    $season = $row['season'];
    $days = $row['days'];
    $cost = $row['cost'];
} else {
    echo "City not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/viewjourney.css">
    <title><?php echo $city; ?> Details</title>
</head>
<body> 
    <div class="navbar">
    <span class="logo">Travelscapes</span>
</div>
<div class="content-container">
    <h1>>> <?php echo $city; ?> << </h1>
    
    <div class="city-card">
    <div class="city-images">
    <img src="<?php echo $imageArray[$cityId-1]; ?>" alt="Image Alt Text">
</div>

        <div class="city-details">
            <p><strong>City:</strong> <?php echo $city; ?></p>
            <p><strong>Region:</strong> <?php echo $region; ?></p>
            <p><strong>Season:</strong> <?php echo $season; ?></p>
            <p><strong>Days:</strong> <?php echo $days; ?></p>
            <p><strong>Cost:</strong> Rs <?php echo $cost; ?></p>
        </div>
        <div class="view-hotels-button">
            <a href="view_hotels.php?city_id=<?php echo $cityId; ?>" class="view-button">View Hotels</a>
        </div>
    </div>

    <?php
    $conn->close();
    ?>
    </div>
    <footer>
    <p>&copy; 2024 Travelscapes. All rights reserved.</p>
</footer>

</body>
</html>
