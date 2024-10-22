    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header("Location: index.php"); // Redirect to index.php if not logged in
        exit();
    }
    ?>
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
            <input type="text" placeholder="&#x1F50D; Search">
            <div class="search-icon">
                <p>&#x1F50D;</p>
            </div>
            <div class="icons">
                <a href="home.php"><p>Home</p></a>
                <a href="#" id="profile">
                    <img src="img/profile.png" alt="Profile">
                    <span class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </a>
                <a href="#"><img src="img/messages.png" alt="Messages"></a>
                <!-- Sign-out link wrapped around the three dots icon -->
                <a href="signout.php"><img src="img/dots.png" alt="Extra Menu"></a>
            </div>
        </div>
        <div class="container">
            <div class="tile-container">
                <!-- Example of tile items -->
                <?php for ($i = 1; $i <= 16; $i++): ?>
                <div class="tile">
                    <img src="img/tile<?php echo $i; ?>.jpg" alt="tile picture">
                    <div class="overlay">
                        <img src="img/share.png" alt="share icon">
                        <p>&#9906; Save</p>
                    </div>
                    <div class="tile-bottom">
                        <p>Tile Description <?php echo $i; ?></p>
                        <img src="img/dots.png" alt="Extra Tile Menu" style="cursor: pointer;">
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="bottom-float">
            <p class="float-icon">+</p>
            <p class="float-icon">?</p>
            <p class="float-icon" id="privacy">Privacy</p>
            
        </div>
    </body>
    </html>
