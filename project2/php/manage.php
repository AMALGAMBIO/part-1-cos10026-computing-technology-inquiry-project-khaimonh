<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start(); // Start the session, creates $_SESSION
// Check if the user is logged in
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { //if $_SESSION is not set or not true
//     header("Location: login.php"); // Redirect to login page if not logged in
//     exit; 
// }
include 'header.inc';
include 'menu.inc';
require_once 'settings.php' ;
// if (isset($conn)) {
//     switch (connection_status()) {
//         case CONNECTION_NORMAL:
//             $txt = 'Connection is in a normal state';
//             break;
//         case CONNECTION_ABORTED:
//             $txt = 'Connection aborted';
//             break;
//         case CONNECTION_TIMEOUT:
//             $txt = 'Connection timed out';
//             break;
//         case (CONNECTION_ABORTED & CONNECTION_TIMEOUT):
//             $txt = 'Connection aborted and timed out';
//             break;
//         default:
//             $txt = 'Unknown';
//             break;
//     }
//     echo $txt;
// } else {
//     die("Connection failed: " . mysqli_connect_error());
// }

?>

<h3>All Applications</h3>
<div id="allEOIs">
    <!-- PHP script will load all applications here -->
<?php

function fetchAndDisplayEOIs($conn, $query, $params = []) {
    $stmt = $conn->prepare($query); //prepare the query statement

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    
    if (!empty($params)) { //bind parameter if needed
        $stmt->bind_param(...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Debug: Check the number of rows
    echo "Number of rows found: " . $result->num_rows . "<br>";

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>EOI Number</th>";
        echo "<th>Job Reference</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Address</th>";
        echo "<th>Email</th>";
        echo "<th>Phone</th>";
        echo "<th>Skills</th>";
        echo "<th>Status</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["EOInumber"] . "</td>";
            echo "<td>" . $row["JobRef"] . "</td>";
            echo "<td>" . $row["FirstName"] . "</td>";
            echo "<td>" . $row["LastName"] . "</td>";
            echo "<td>" . $row["Address"] . "</td>";
            echo "<td>" . $row["Email"] . "</td>";
            echo "<td>" . $row["Phone"] . "</td>";
            echo "<td>" . $row["Skills"] . "</td>";
            echo "<td>" . $row["Status"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No EOIs found.<br>";
    }

    $stmt->close();
}

$query = "SELECT * FROM eoi ORDER BY EOInumber ASC";
fetchAndDisplayEOIs($conn, $query);
?>
</div>
<h3>Search by Job Reference</h3>
<form method="post" action="manage.php">
    <input type="text" name="JobRef" placeholder="Enter Job Reference" required>
    <button type="submit" name="searchByJob">Search</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchByJob"])) {
    $jobRef = trim($_POST["JobRef"]);
    echo "JobRef entered: " . htmlspecialchars($jobRef) . "<br>";

    $query = "SELECT * FROM eoi WHERE JobRef = ? ORDER BY EOInumber ASC";
    echo "Executing query: " . $query . "<br>";

    fetchAndDisplayEOIs($conn, $query, ["s", $jobRef]);
}
?>
<h3>Search by Applicant Name</h3>
<form method="post" action="manage.php">
    <input type="text" name="firstName" placeholder="Enter First Name">
    <input type="text" name="lastName" placeholder="Enter Last Name">
    <button type="submit" name="searchByName">Search</button>
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchByName"])){
    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    if (empty($firstName) && empty($lastName)) {
        echo "Please enter a first name or last name. <br>";
    }
    elseif(empty($firstName)){
        echo "Last Name entered: " . htmlspecialchars($lastName) . "<br>";   
    }
    
    elseif(empty($lastName)){
        echo "First Name entered: " . htmlspecialchars($firstName) . "<br>";   
    }
    
    else{
        echo "First Name entered: " . htmlspecialchars($firstName) . "<br>";
        echo "Last Name entered: " . htmlspecialchars($lastName) . "<br>";   
    }
    $query = "SELECT * FROM eoi WHERE FirstName = ? and LastName = ? ORDER BY EOInumber ASC";
    echo "Executing query: " . $query . "<br>";

    fetchAndDisplayEOIs($conn, $query, ["ss", $firstName, $lastName]);
}
?>
<h3>Delete Applications</h3>
<form method="post" action="manage.php">
    <input type="text" name="deleteJobRef" placeholder="Enter Job Reference to Delete" required>
    <button type="submit" name="deleteEOI">Delete</button>
</form>
<?php require "footer.inc"; 
 ?>
<?php
// // Check if the search form was submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
//     $jobRef = trim($_POST["jobRef"]); 

//     // Prevent SQL Injection by using a prepared statement
//     $stmt = $conn->prepare("SELECT * FROM eoi WHERE JobRef = ?"); //JobRef is a key in the table
//     $stmt->bind_param("s", $jobRef); 
//     $stmt->execute();
//     $result = $stmt->get_result();
// } else {
//     // If no search, get all EOIs
//     $result = $conn->query($sql);
// }
?>