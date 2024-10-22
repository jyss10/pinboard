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

// Initialize variables for errors
$signup_error = '';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    // Retrieve and sanitize user input
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($username) || empty($password)) {
        $signup_error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_error = "Invalid email format.";
    } else {
        // Check if email or username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $signup_error = "Email or Username already exists.";
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and bind the SQL statement
            $stmt_insert = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("sss", $email, $username, $hashed_password);

            // Execute the statement
            if ($stmt_insert->execute()) {
                // Redirect to index.php with query parameters to show login form and success message
                header("Location: index.php?signup=true");
                exit();
            } else {
                $signup_error = "Error: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        }

        $stmt->close();
    }

    // If there's an error, redirect back with the error message
    if (!empty($signup_error)) {
        // It's better to pass the error via session to prevent URL manipulation
        $_SESSION['signup_error'] = $signup_error;
        header("Location: index.php?signup=failed");
        exit();
    }
}

$conn->close();
?>
