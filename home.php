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
    // Save the image URL to the user's session (or database)
    $_SESSION['saved_images'][] = $imageUrl;
    echo "<script>alert('Image saved to your profile!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>PINboard</title>
    <link rel="stylesheet" href="homecss.css"> 
    <style> /* Header styling */

/* Search Bar Styling */
.search-form {
    flex: 1;
    display: flex;
    justify-content: center; /* Center the search bar horizontally */
    align-items: center;    /* Center the search bar vertically */
    margin: 0 20px;         /* Add space between logo and icons */
}

.search-form form {
    width: 100%;
    max-width: 800px;       /* Restrict the maximum width of the search bar */
    display: flex;
    align-items: center;
}

.search-form input {
    flex: 1;
    height: 40px;
    padding: 0px 10px; /* Adjusted padding for taller input */
    border: 1px solid #ddd;
    border-radius: 20px; /* Adjusted to a more rounded corner */
    font-size: 16px; /* Make text easily readable */
}


.search-form button {
    padding: 8px 12px;
    background-color: #e60023;
    color: white;
    border: none;
    border-radius: 15px; /* Rounded corners for the right side */
    cursor: pointer;
    font-size: 16px; /* Match font size */
}

.search-form button:hover {
    background-color: #b0001b; /* Darker shade for hover effect */
}

/* Icons Styling */
.icons {
    display: flex;
    align-items: center;
}

.icons a {
    margin-left: 15px;
    color: #555;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.icons a.active {
    font-weight: bold;
    color: #e60023;
}

.icons img {
    height: 24px;
    width: 24px;
    margin-right: 5px;
}

.icons .profile-name {
    font-size: 14px;
    font-weight: bold;
    color: #333;
}


/* Chat Modal Styling */
.chat-modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.chat-modal-content {
    background-color: white;
    margin: 15% auto;
    padding: 20px;
    border-radius: 10px;
    width: 400px;
}

.close-chat {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-chat:hover, .close-chat:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.chat-box {
    display: flex;
    flex-direction: column;
}

.messages {
    margin-bottom: 10px;
    padding: 10px;
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #f9f9f9;
    flex-grow: 1;
}

/* Style for User's Message */
.messages .message.user {
    text-align: right;
    background-color: #d1f7c4;
    padding: 10px;
    margin: 5px;
    border-radius: 10px;
}

/* Style for Bot's Message */
.messages .message.bot {
    text-align: left;
    background-color: #e6e6e6;
    padding: 10px;
    margin: 5px;
    border-radius: 10px;
}

/* Styling for the option buttons */
.choices-container {
    display: flex;
    flex-direction: column;
    margin-top: 10px;
    gap: 10px;
    padding: 10px;
}

.option-button {
    background-color: #f1f1f1;
    border: none;
    padding: 8px 16px;
    margin: 5px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
}

.option-button:hover {
    background-color: #ddd;
}

.option-button:focus {
    outline: none;
}


</style><!-- Ensure the path is correct -->
</head>
<body>
<div class="header">
    <div class="logo">
        <img src="img/Pinterest-logo.png" alt="Pinterest logo">
    </div>
    <div class="search-form">
        <form method="GET" action="home.php">
            <input type="text" name="query" placeholder="🔍 Search" value="<?php echo htmlspecialchars($searchQuery); ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="icons">
        <a href="home.php" class="active">Home</a>
        <a href="profile.php" id="profile">
            <img src="img/profile.png" alt="Profile">
            <span class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </a>
        <a href="#" id="message-icon"><img src="img/messages.png" alt="Message icon"></a>
        <!-- HTML for Chat Modal -->
        <div id="chat-modal" class="chat-modal">
            <div class="chat-modal-content">
        <span id="close-chat" class="close-chat">&times;</span>
                <div class="chat-box">
                    <div id="messages" class="messages"></div>
            <!-- The choices will be added here dynamically -->
                </div>
            </div>
        </div>

        <a href="signout.php">Sign Out</a>
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

<script>
// JavaScript for Chat Modal Functionality with Clickable Choices
const messageIcon = document.getElementById("message-icon");
const chatModal = document.getElementById("chat-modal");
const closeChat = document.getElementById("close-chat");
const messagesContainer = document.getElementById("messages");

// Predefined responses
const responses = {
    "hi": "Hello! How can I assist you today?",
    "hello": "Hi there! How are you?",
    "how are you": "I'm doing great, thank you! How about you?",
    "what is pinboard": "PINBoard is a platform where you can save and share content. Feel free to explore!",
    "thank you": "You're welcome! If you need anything else, feel free to ask.",
    "good bye": "Goodbye! Have a wonderful day ahead!"
};

// Open the chat modal when the message icon is clicked
messageIcon.addEventListener("click", () => {
    chatModal.style.display = "block";
    displayWelcomeMessage(); // Display the initial welcome message
});

// Close the chat modal when the close button is clicked
closeChat.addEventListener("click", () => {
    chatModal.style.display = "none";
});

// Close the chat modal if the user clicks outside of the modal content
window.addEventListener("click", (event) => {
    if (event.target === chatModal) {
        chatModal.style.display = "none";
    }
});

// Function to simulate bot typing
function simulateBotTyping(responseText) {
    const typingMessage = document.createElement("div");
    typingMessage.classList.add("message", "bot");
    typingMessage.textContent = "Bot is typing...";
    messagesContainer.appendChild(typingMessage);

    setTimeout(() => {
        // Remove typing message
        typingMessage.remove();

        // Display the actual bot response
        const botMessage = document.createElement("div");
        botMessage.classList.add("message", "bot");
        botMessage.textContent = responseText;
        messagesContainer.appendChild(botMessage);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Show options after bot response
        displayOptions();
    }, 1000); // Bot takes 1 second to "type"
}

// Function to display clickable options below the messages
function displayOptions() {
    const options = [
        { text: "Hi", value: "hi" },
        { text: "Hello", value: "hello" },
        { text: "How are you?", value: "how are you" },
        { text: "What is PINBoard?", value: "what is pinboard" },
        { text: "Thank you", value: "thank you" },
        { text: "Goodbye", value: "good bye" }
    ];

    // Clear previous options if any
    const existingChoicesContainer = document.querySelector(".choices-container");
    if (existingChoicesContainer) {
        existingChoicesContainer.remove();
    }

    const choicesContainer = document.createElement("div");
    choicesContainer.classList.add("choices-container");

    // Create the clickable options
    options.forEach(option => {
        const optionButton = document.createElement("button");
        optionButton.classList.add("option-button");
        optionButton.textContent = option.text;
        optionButton.addEventListener("click", () => handleOptionClick(option.value, option.text));
        choicesContainer.appendChild(optionButton);
    });

    messagesContainer.appendChild(choicesContainer);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Handle option button click (user selects an option)
function handleOptionClick(optionValue, optionText) {
    // Display user's choice in the chat
    const userMessage = document.createElement("div");
    userMessage.classList.add("message", "user");
    userMessage.textContent = optionText;
    messagesContainer.appendChild(userMessage);

    // Get the bot's response
    const response = responses[optionValue] || "Sorry, I didn't understand that.";

    // Display the bot's response directly after the user clicks the option (no user message)
    simulateBotTyping(response);
}

// Function to display the initial welcome message with options
function displayWelcomeMessage() {
    const welcomeMessage = document.createElement("div");
    welcomeMessage.classList.add("message", "bot");
    welcomeMessage.textContent = "Hello, Welcome to PINboard! How can I help you today?";
    messagesContainer.appendChild(welcomeMessage);

    displayOptions(); // Show the clickable options for the user
}


</script>

</html>
