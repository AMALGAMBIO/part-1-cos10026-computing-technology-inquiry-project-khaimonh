<?php
session_start(); // Start the session
include 'header.inc'; // Include header
require_once 'settings-manage.php'; // Include database settings

// Redirect to manage.php if already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: manage.php");
    exit;
}
?>
<link rel="stylesheet" href="styles/login-register.css">
</head>

<body>
    <nav>
    <a href="index.php" class="home">BITBOPS</a>
</nav>
    <div class="container">
        <h1>Register</h1>
        <form action="register-enhancement.php" method="post">
            <label class="register-input" for="username">Admin Username</label>
            <input class="register-input" type="text" name="username" id="username" required>
            <br>    
            <label class="register-input" for="password">Admin Password</label>
            <input class="register-input" type="password" name="password" id="password" required>
            <br>
            <input class="submit-button" type="submit" name="register" value="Register">
        </form>
    </div>
</body>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Check if the user already exists
    $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "User already exists.";
        $stmt->close();
        exit;
    } else {
        // Register the user
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?);");
        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // $role = 'admin'; // Default role for new users
        $stmt->bind_param("ss", $username, $hashedPassword);
        if ($stmt->execute()) {
            echo "User registered successfully.";
        } else {
            echo "Error registering user: " . $stmt->error;
        }
        $stmt->close();
    }
}
session_unset();
session_destroy();
include 'footer.inc'; // Include footer
?>