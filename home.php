<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to index.php if not logged in
    exit();
}

// Your Unsplash Access Key
$accessKey = 'BhP2TvI1SIbsHz6Hzp1g9wSXSPXE78Cjxf6I1HJ-HmU';

// Capture the search query if there is one
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Build the Unsplash API URL
$url = "https://api.unsplash.com/photos?client_id=$accessKey";
if ($searchQuery) {
    $url = "https://api.unsplash.com/search/photos?client_id=$accessKey&query=" . urlencode($searchQuery);
}

// Fetch images from Unsplash
$response = file_get_contents($url);

// Decode the JSON response into an associative array
$images = json_decode($response, true);

// Save image to the user's profile if requested
if (isset($_POST['save_image'])) {
    $imageUrl = $_POST['image_url'];  // Image URL to save

    // Check if the file exists, otherwise create it
    $savedImagesFile = 'saved_images.json';
    if (file_exists($savedImagesFile)) {
        $savedImages = json_decode(file_get_contents($savedImagesFile), true);
    } else {
        $savedImages = [];
    }

    // Add the new saved image
    $savedImages[] = $imageUrl;

    // Save the updated list back to the file
    file_put_contents($savedImagesFile, json_encode($savedImages));
    echo "<script>alert('Image saved to your profile!');</script>";
}
?>

<!-- The HTML and other parts stay the same as before -->


<!DOCTYPE html>
<html lang="en">
<head>
    <title>PINboard</title>
    <link rel="stylesheet" href="homecss.css"> <!-- Ensure the path is correct -->
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="img/Pinterest-logo.png" alt="Pinterest logo" style="height: 40px;width: 40px;">
        </div>
        <!-- Search Form -->
        <form method="GET" action="home.php">
            <input type="text" name="query" placeholder="&#x1F50D; Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <div class="search-icon">
                <button type="submit">&#x1F50D;</button>
            </div>
        </form>
        <div class="icons">
            <a href="home.php"><p>Home</p></a>
            <a href="profile.php" id="profile">
                <img src="img/profile.png" alt="Profile">
                <span class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>
            <a href="#"><img src="img/messages.png" alt="Messages"></a>
            <a href="signout.php"><img src="img/dots.png" alt="Extra Menu"></a>
        </div>
    </div>
    <div class="container">
        <div class="tile-container">
            <?php
            // Check if we got data
            if (is_array($images) && !empty($images)) {
                // Loop through the images and display them
                $imageResults = $searchQuery ? $images['results'] : $images;
                foreach ($imageResults as $image) {
                    echo '<div class="tile">';
                    // Display the image itself
                    echo '<img src="' . $image['urls']['regular'] . '" alt="tile picture">';
                    // Overlay with Share and Save options
                    echo '<div class="overlay">';
                    echo '<img src="img/share.png" alt="share icon">';
                    // Save Button Form
                    echo '<form method="POST" action="home.php">';
                    echo '<input type="hidden" name="image_url" value="' . htmlspecialchars($image['urls']['regular']) . '">';
                    echo '<button type="submit" name="save_image"><p>&#9906; Save</p></button>';
                    echo '</form>';
                    echo '</div>';
                    // Tile description and menu
                    echo '<div class="tile-bottom">';
                    echo '<p>' . htmlspecialchars($image['alt_description']) . '</p>';
                    echo '<img src="img/dots.png" alt="Extra Tile Menu" style="cursor: pointer;">';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo 'No images found.';
            }
            ?>
        </div>
    </div>
    <div class="bottom-float">
        <p class="float-icon">+</p>
        <p class="float-icon">?</p>
        <p class="float-icon" id="privacy">Privacy</p>
    </div>
</body>
</html>
