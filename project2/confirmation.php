<?php include 'header.inc'; ?>
<?php include 'menu.inc'; ?>
<link rel="stylesheet" href="./styles/confirmation.css">
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

//Handle the job number
if (isset($_POST['jobnumber'])) {
    $jobnumber = $_POST['jobnumber'];
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
} else {
die("File upload error: " . $_FILES['cv_image']['error']);
}

// Set PHP configuration for file uploads
ini_set('file_uploads', 'On');
ini_set('upload_max_filesize', '40M');
ini_set('post_max_size', '50M');

$conn = new mysqli($host, $user, $password, $database);


$stmt = $conn->prepare("INSERT INTO eoi (`Job Reference Number`, `First Name`, `Last Name`, `Gender`, `Phone number`, `Street Address`, `Suburb Town`, `State`, `Email Address`, `CV Images`, `Other Skills`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind all parameters
$stmt->bind_param("sssssssssss", $jobnumber, $fname, $lname, $gender, $tel, $address, $stown, $state, $email, $targetFilePath, $skills);

if ($stmt->execute()) {
    // Retrieve the auto-generated EOInumber
    $eoiNumber = $conn->insert_id;

    //Display the confirmation message
    echo "<h2>Application Submitted Successfully</h2>";
    echo "<p>Your unique EOI number is: <strong>$eoiNumber</strong>.</p>";
    echo "<p>We have received your application for the position of <strong>$jobnumber</strong>.</p>";
    echo "<p><strong>First Name:</strong> $fname</p>";
    echo "<p><strong>Last Name:</strong> $lname</p>";
    echo "<p><strong>Gender:</strong> $gender</p>";
    echo "<p><strong>Last Name:</strong> $lname</p>";
    echo "<p><strong>Phone Number:</strong> $tel</p>";
    echo "<p><strong>Street Address:</strong> $address</p>";
    echo "<p><strong>Suburb/Town:</strong> $stown</p>";
    echo "<p><strong>State:</strong> $state</p>";
    echo "<p><strong>Email Address:</strong> $email</p>";
    echo "<p><strong>CV Image:</strong> <a href='$targetFilePath'>$fileName</a></p>";
    echo "<p><strong>Other Skills:</strong> $skills</p>";
    echo "<p>Thank you for your application. We will review it and get back to you soon.</p>";
} else {
    echo "<p>Something went wrong: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();

?>

<?php include 'footer.inc'; ?>
