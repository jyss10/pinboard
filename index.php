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
            <a href="#" class="logo">
                <img src="images/pinterestlogo.png" alt="logo">
                <h2>PinBoard</h2>
            </a>
            <ul class="links">
                <span class="close-btn material-symbols-rounded">close</span>
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Business</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        <div class="buttons">
            <button class="login-btn">LOG IN</button>
            <button class="signup-btn">SIGN UP</button>
        </div>
        </nav>
    </header>

    <!-- Notification for successful signup -->
    <?php if (isset($_GET['signup']) && $_GET['signup'] == 'true'): ?>
        <div class="notification">
            Thank you for signing up!<br>
            Your account has been created successfully.
        </div>
    <?php endif; ?>

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
                <form action="#">
                    <div class="input-field">
                        <p>Email:</p>
                        <input type="text" required>
                        <label>Enter your email</label>
                    </div>
                    <div class="input-field">
                        <p>Password:</p>
                        <input type="password" required>
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
                        <label for="policy">I agree the<a href="#" class="option">Terms & Conditions</a>
                        </label>
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
