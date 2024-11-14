<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PINboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <nav class="navbar">
            <span class="hamburger-btn material-symbols-rounded">menu</span>
            <a href="index.php" class="logo">
                <img src="img/pinterestlogo.png" alt="logo">
                <h2>PINboard</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="#">Business</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
            <div class="buttons">
                <button class="login-btn">LOG IN</button>
                <button class="signup-btn">SIGN UP</button>
            </div>
        </nav>
    </header>

    <div class="wallpaper" style="display: flex;position:relative;justify-content:center;align-items:center;top:80px;height:calc(100vh - 80px);width:100%;">
        <img src="img/Wallpaper.jpg" alt="wallpaper" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;z-index:-1;">
        <h1 style="text-align: center; z-index: 1;font-size: 350%;font-family:'Courier New', Courier, monospace;">Explore more in PINboard</h1>
    </div>

    <!-- Notification for successful signup -->
    <?php if (isset($_GET['signup']) && $_GET['signup'] == 'true'): ?>
        <div class="notification">
            Thank you for signing up!<br>
            Your account has been created successfully.
        </div>
    <?php endif; ?>


    <?php 
// Display login errors
if (isset($_SESSION['login_error'])) {
    echo "<div class='error'>".$_SESSION['login_error']."</div>";
    unset($_SESSION['login_error']); // Clear after showing
}

// Display signup errors
if (isset($_SESSION['signup_error'])) {
    echo "<div class='error'>".$_SESSION['signup_error']."</div>";
    unset($_SESSION['signup_error']); // Clear after showing
}
?>
    
    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back to PINboard</h2>
                <p>We've missed you!</p>
            </div>
            <div class="form-content">
                <h2>LOGIN</h2>
                <form action="login-handler.php" method="POST">
                    <div class="input-field">
                        <p>Email:</p>
                        <input type="text" name="email" required>
                        <label>Enter your email</label>
                    </div>
                    <div class="input-field">
                        <p>Password:</p>
                        <input type="password" name="password" required>
                        <label>Enter your password</label>
                    </div>
                    <a href="#" class="forgot-pass-link">Forgot password?</a>
                    <button type="submit">Log In</button>
                </form>
                <div class="bottom-link">
                    Don't have an account?
                    <a href="#" id="signup-link">Signup</a>
                </div>
            </div>
        </div>
        <div class="form-box signup">
            <div class="form-details">
                <h2>Create an Account</h2>
                <p>Welcome to PINboard new user!</p>
                <p>To become a part of our community, please sign up now!</p>
            </div>
            <div class="form-content">
                <h2>SIGNUP</h2>
                <form action="form-handler.php" method="POST">
                    <div class="input-field">
                        <p>Email:</p>
                        <input type="text" name="email" required>
                        <label>Enter your email</label>
                    </div>
                    <div class="input-field">
                        <p>Username:</p>
                        <input type="text" name="username" required>
                        <label>Create username</label>
                    </div>
                    <div class="input-field">
                        <p>Password:</p>
                        <input type="password" name="password" required>
                        <label>Create password</label>
                    </div>
                    <div class="policy-text">
                        <input type="checkbox" id="policy" required>
                        <label for="policy">I agree to the <a href="#" class="option">Terms & Conditions</a></label>
                    </div>
                    <button type="submit">Sign Up</button>
                </form>
                <div class="bottom-link">
                    Already have an account? 
                    <a href="#" id="login-link">Login</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Display login form if `showLogin` query parameter is true
        <?php if (isset($_GET['showLogin']) && $_GET['showLogin'] == 'true'): ?>
            document.body.classList.add("show-popup");
            document.querySelector(".form-popup").classList.remove("show-signup");
        <?php endif; ?>
    </script>
</body>
</html>