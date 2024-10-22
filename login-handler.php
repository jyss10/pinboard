<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "user_registration";

// Create a connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize login error
$login_error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
        $login_error = "Please fill in all fields.";
    } else {
        // Prepare and execute the SQL statement
        $stmt = $conn->prepare("SELECT password, username FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if email exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password, $username);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Set session variables
                $_SESSION['username'] = $username;

                // Redirect to home.php
                header("Location: home.php");
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "Email not found.";
        }

        $stmt->close();
    }

    // If there's an error, redirect back with the error message
    if (!empty($login_error)) {
        // It's better to pass the error via session to prevent URL manipulation
        $_SESSION['login_error'] = $login_error;
        header("Location: index.php?login=failed");
        exit();
    }
}

$conn->close();
?>
