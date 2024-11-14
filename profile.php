<?php
session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the user has saved images in the session
$savedImages = isset($_SESSION['saved_images']) ? $_SESSION['saved_images'] : [];

// Load saved images from the file
$savedImagesFile = 'saved_images.json';
if (file_exists($savedImagesFile)) {
    $savedImages = json_decode(file_get_contents($savedImagesFile), true);
} else {
    $savedImages = [];
}

// Handle profile update (if any)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    // Update the username (nickname) and password (if provided)
    $newUsername = $_POST['username'];

    // Update session variables
    $_SESSION['username'] = $newUsername;
    if (!empty($newPassword)) {
        // Password update logic (hashing before saving)
        $_SESSION['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
    }

    $message = "Profile updated successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - PINboard</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>
    <!-- Updated header -->
    <div class="header">
        <div class="logo">
            <img src="img/Pinterest-logo.png" alt="Pinterest logo" style="height: 40px;width: 40px;">
        </div>
        <div class="icons">
            <a href="home.php">Home</a>
            <a href="profile.php" class="active">Profile</a>
            <a href="signout.php">Sign Out</a>
        </div>
    </div>

    <div class="profile-container">
        <div class="profile-info">
            <h2>Profile</h2>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            
            <!-- Button to toggle Update Profile Form -->
            <button onclick="toggleUpdateForm()">Update Profile</button>

            <!-- Update Profile Form (Initially hidden) -->
            <div id="update-form" style="display: none;">
                <h3>Update Your Profile</h3>
                <form method="POST" action="profile.php">
                    <label for="username">Username:</label>
                    <input type="text" name="username" placeholder="Update your username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
                    <br>

                    <button type="submit" name="update_profile">Update Profile</button>
                </form>
            </div>
            
            <?php
            if (isset($message)) {
                echo "<p class='message'>$message</p>";
            }
            ?>
        </div>

        <div class="saved-images">
            <?php
            if (count($savedImages) > 0) {
                foreach ($savedImages as $image) {
                    echo '<div class="saved-image">';
                    echo '<img src="' . $image . '" alt="Saved Image" width="200">';
                    echo '</div>';
                }
            } else {
                echo '<p>No saved images yet.</p>';
            }
            ?>
        </div>
    </div>

    <script>
        // Function to toggle the update form
        function toggleUpdateForm() {
            const updateForm = document.getElementById('update-form');
            if (updateForm.style.display === "none") {
                updateForm.style.display = "block";
            } else {
                updateForm.style.display = "none";
            }
        }
    </script>
</body>
</html>
