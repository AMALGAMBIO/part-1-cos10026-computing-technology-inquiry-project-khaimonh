<?php

include 'header.inc';
include 'menu.inc';
?>

<h2> EOI records table</h2>

<?php
//Connect to database
require_once "settings.php";
$conn = mysqli_connect("$host", "$user", "$password", "$database");
if($conn) {
  $query = "SELECT * FROM `EOI`";                                   //Insert query
  $result = mysqli_query ($conn, $query);
if ($result) {
    $record = mysqli_fetch_assoc($result);
    echo "<table border='1'>";
    echo "<tr>
    <th>ID</th>
    <th>Job Reference Number</th>
    <th>First name</th>
    <th>Last name</th>
    <th>Gender</th>
    <th>Phone number</th>
    <th>Street Address</th>
    <th>Suburb Town</th>
    <th>State</th>
    <th>Email Address</th>
    <th>Other skills</th>
    <th>Status</th></tr>";

while($record) {
    echo "<tr><td>{$record['EOInumber']}</td>";
    echo "<td>{$record['Job Reference Number']}</td>";
    echo "<td>{$record['First Name']}</td>";
    echo "<td>{$record['Last Name']}</td>";
    echo "<td>{$record['Gender']}</td></tr>";
    echo "<td>{$record['Phone number']}</td></tr>";
    echo "<td>{$record['Street Address']}</td></tr>";
    echo "<td>{$record['Suburb Town']}</td></tr>";
    echo "<td>{$record['State']}</td></tr>";
    echo "<td>{$record['Email Address']}</td></tr>";
    echo "<td>{$record['Other Skills']}</td></tr>";
    echo "<td>{$record['Status']}</td></tr>";
    $record = mysqli_fetch_assoc($result);
}
echo "</table>";
mysqli_free_result($result);
}  
  echo "<p>Connection successful</p>";
  mysqli_close($conn);
} else {
  echo "<p>Connection failed</p>";
}
?>

<?php require "footer.inc";  ?>

