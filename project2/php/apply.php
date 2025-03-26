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


$conn = mysqli_connect($host, $user, $password, $database);
if($conn) {
  echo "<p>Connection successful</p>";
 
} else {
  echo "<p>Connection failed</p>";
}

$query = "INSERT INTO `eoi`(Job Reference Number, First Name, Last Name, Gender, Phone Number, Street Address, Suburb Town, State, Email Address, Other Skills)
          VALUES($jobnumber, $fname, $lname, $gender, $tel, $address, $stown, $state, $email, $skills)";

$result = mysqli_query($conn, $query);

mysqli_close($conn);
if(!$result) {
    echo "<p> Something is wrong with ", $query, "</p>";
}
else {
    echo "<p> Successfully added New data record</p>";
}



?>

<?php include 'footer.inc'; ?>
