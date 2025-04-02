<?php
session_start(); // Start the session
include 'header.inc'; // Include header


require_once 'settings.php'; // Include database settings

// Redirect to manage.php if already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: manage.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        echo "Please fill in both username and password.";
        exit;
    }

    // Query to check if the username exists in the database
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute(); 
    $stmt->store_result();

    if ($stmt->num_rows > 0) { // If user exists
        $stmt->bind_result( $dbUsername, $dbPassword);
        $stmt->fetch();

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $dbPassword)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $dbUsername;
            header("Location: manage.php"); // Redirect to the manage page
            exit;
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "User does not exist.";
    }

    $stmt->close();
}
?>
<link rel="stylesheet" href="styles/login-register.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="login-enhancement.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
    <?php
    include 'footer.inc'; // Include footer
    ?>
</body>


