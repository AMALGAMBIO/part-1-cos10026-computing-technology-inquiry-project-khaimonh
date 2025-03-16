<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobReference = trim($_POST['jobReference']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $streetAddress = trim($_POST['streetAddress']);
    $suburb = trim($_POST['suburb']);
    $state = $_POST['state'];
    $postcode = trim($_POST['postcode']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $skill1 = isset($_POST['skill1']) ? trim($_POST['skill1']) : null;
    $skill2 = isset($_POST['skill2']) ? trim($_POST['skill2']) : null;
    $skill3 = isset($_POST['skill3']) ? trim($_POST['skill3']) : null;
    $otherSkills = trim($_POST['otherSkills']);
}
require_once("settings.php");
$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$insertSQL = "INSERT INTO eoi (jobReference, firstName, lastName, streetAddress, suburb, state, postcode, email, phone, skill1, skill2, skill3, otherSkills, status)
              VALUES ('$jobReference', '$firstName', '$lastName', '$streetAddress', '$suburb', '$state', '$postcode', '$email', '$phone', '$skill1', '$skill2', '$skill3', '$otherSkills', 'New')";
if ($conn->query($insertSQL) === TRUE) {
    echo "EOI submitted successfully. Your EOI Number is: " . $conn->insert_id;
} else {
    echo "Error: " . $insertSQL . "<br>" . $conn->error;
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
    exit();
}
?>