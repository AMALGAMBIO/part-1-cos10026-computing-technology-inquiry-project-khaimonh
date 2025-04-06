<?php include 'header.inc'; ?>
<?php include 'menu.inc'; ?>
<link rel="stylesheet" href="./styles/confirmation.css">
<?php

// Connect to the database
require_once "settings.php";

// Receive data from the form
$fname = trim($_POST['fname']);
$lname = trim($_POST['lname']);
$tel = trim($_POST['tel']);
$gender = trim($_POST['gender']);
$address = trim($_POST['address']);
$stown = trim($_POST['stown']);
$state = trim($_POST['state']);
$email = trim($_POST['email']);
$jobnumbers = $_POST['jobnumber']; 
$skills = trim($_POST['skills']);

// Check for file upload
if (!isset($_FILES['cv_image'])) {
    echo "<pre>";
    print_r($_FILES); 
    echo "</pre>";
    die("File input 'cv_image' is missing. Please check your form.");
}

// Handle CV file upload
if ($_FILES['cv_image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "cv_images/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    $fileName = uniqid() . "_" . basename($_FILES['cv_image']['name']);
    $targetFilePath = $targetDir . $fileName;
    move_uploaded_file($_FILES['cv_image']['tmp_name'], $targetFilePath);
} else {
    die("File upload error: " . $_FILES['cv_image']['error']);
}

// Configure PHP upload if necessary
ini_set('file_uploads', 'On');
ini_set('upload_max_filesize', '40M');
ini_set('post_max_size', '50M');

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO eoi (`Job Reference Number`, `First Name`, `Last Name`, `Gender`, `Phone number`, `Street Address`, `Suburb Town`, `State`, `Email Address`, `CV Images`, `Other Skills`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sssssssssss", $jobnumberSingle, $fname, $lname, $gender, $tel, $address, $stown, $state, $email, $targetFilePath, $skills);

$firstEOI = null;

// Loop through each job number and insert separately
foreach ($jobnumbers as $jobnumberSingle) {
    if ($stmt->execute()) {
        if ($firstEOI === null) {
            $firstEOI = $conn->insert_id;
        }
    } else {
        echo "<p>Insert failed for job $jobnumberSingle: " . $stmt->error . "</p>";
    }
}

$stmt->close();
$conn->close();

// Display success message
echo "<h2>Application Submitted Successfully</h2>";
echo "<p>Your unique EOI number is: <strong>$firstEOI</strong>.</p>";
echo "<p>We have received your application for the position(s) of <strong>" . implode(", ", $jobnumbers) . "</strong></p>";
echo "<p><strong>First Name:</strong> $fname</p>";
echo "<p><strong>Last Name:</strong> $lname</p>";
echo "<p><strong>Gender:</strong> $gender</p>";
echo "<p><strong>Phone Number:</strong> $tel</p>";
echo "<p><strong>Street Address:</strong> $address</p>";
echo "<p><strong>Suburb/Town:</strong> $stown</p>";
echo "<p><strong>State:</strong> $state</p>";
echo "<p><strong>Email Address:</strong> $email</p>";
echo "<p><strong>CV Image:</strong> <a href='$targetFilePath'>$fileName</a></p>";
echo "<p><strong>Other Skills:</strong> $skills</p>";
echo "<p>Thank you for your application. We will review it and get back to you soon.</p>";

?>
<?php include 'footer.inc'; ?>
