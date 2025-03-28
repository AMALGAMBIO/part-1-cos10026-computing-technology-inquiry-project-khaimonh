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


$conn = new mysqli($host, $user, $password, $database);
if($conn) {
  echo "<p>Connection successful</p>";
 
} else {
  echo "<p>Connection failed</p>";
}

$stmt = $conn->prepare("INSERT INTO eoi (`Job Reference Number`, `First Name`, `Last Name`, `Gender`, `Phone number`, `Street Address`, `Suburb Town`, `State`, `Email Address`, `Other Skills`)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $jobnumber, $fname, $lname, $gender, $tel, $address, $stown, $state, $email, $skills);

if ($stmt->execute()) {
    echo "<p>Successfully added new data record</p>";
} else {
    echo "<p>Something went wrong: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();

?>

<?php include 'footer.inc'; ?>
