<?php include 'header.inc'; ?>
<?php include 'menu.inc'; ?>
<?php

//Connect to database
require_once "settings.php";

// Assign the values
$fname = trim($_POST['fname']);
$lname = trim($_POST['lname']);
$tel = trim($_POST['tel']);
$gender = trim($_POST['gender']);
$address = trim($_POST['address']);
$stown = trim($_POST['stown']);
$state = trim($_POST['state']);
$email = trim($_POST['email']);
$jobnumber = trim($_POST['jobnumber']);
$skills = trim($_POST['skills']);

//Handle the job numble 
if (isset($_POST['jobnumber'])) {
    $jobnumber = $_POST['jobnumber'];
    echo "<p>Applying for Job Reference Number: $jobnumber</p>";
}

// Debugging: Check if the file input exists
if (!isset($_FILES['cv_image'])) {
    echo "<pre>";
    print_r($_FILES); // Debug the $_FILES array
    echo "</pre>";
    die("File input 'cv_image' is missing. Please check your form.");
}

// Handle CV image upload
if ($_FILES['cv_image']['error'] === UPLOAD_ERR_OK) {
    $targetDir = "cv_images/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Create the directory if it doesn't exist
    }

    // Generate a unique file name to avoid overwriting
    $fileName = uniqid() . "_" . basename($_FILES['cv_image']['name']);
    $targetFilePath = $targetDir . $fileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['cv_image']['tmp_name'], $targetFilePath)) {
        echo "File uploaded successfully: " . $targetFilePath . "<br>";
    } else {
        die("Failed to move the uploaded file.");
    }
} else {
    die("File upload error: " . $_FILES['cv_image']['error']);
}

// Set PHP configuration for file uploads
ini_set('file_uploads', 'On');
ini_set('upload_max_filesize', '40M');
ini_set('post_max_size', '50M');

$conn = new mysqli($host, $user, $password, $database);
if ($conn) {
    echo "<p>Connection successful</p>";
} else {
    die("<p>Connection failed: " . $conn->connect_error . "</p>");
}

$stmt = $conn->prepare("INSERT INTO eoi (`Job Reference Number`, `First Name`, `Last Name`, `Gender`, `Phone number`, `Street Address`, `Suburb Town`, `State`, `Email Address`, `CV Images`, `Other Skills`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind all parameters
$stmt->bind_param("sssssssssss", $jobnumber, $fname, $lname, $gender, $tel, $address, $stown, $state, $email, $targetFilePath, $skills);

if ($stmt->execute()) {
    echo "<p>Successfully added new data record</p>";
    header("Location: process_eoi.php");
} else {
    echo "<p>Something went wrong: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();

?>

<?php include 'footer.inc'; ?>
