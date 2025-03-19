
<?php 

session_start(); // Start the session, creates $_SESSION

// Check if the user is logged in
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { //if $_SESSION is not set or not true
//     header("Location: login.php"); // Redirect to login page if not logged in
//     exit; 
// }
include 'header.inc';
include 'menu.inc';
// require_once 'settings.php' 
// $sql = "SELECT * FROM eoi ORDER BY EOInumber DESC";
// $result = $conn->query($sql);
?>
<h3>All Applications</h3>
<div id="allEOIs">
    <!-- PHP script will load all applications here -->
 <table border="1">
    <tr>
        <th>EOI Number</th>
        <th>Job Reference</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Address</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Skills</th>
        <th>Status</th>
    </tr>
</table>
<?php
    if ($result->num_rows > 0) {
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
    } else {
        echo "<tr><td colspan='8'>No EOIs found</td></tr>";
    }?>
</div>
<h3>Search by Job Reference</h3>
<form method="post" action="manage.php">
    <input type="text" name="jobRef" placeholder="Enter Job Reference" required>
    <button type="submit" name="searchByJob">Search</button>
</form>
<h3>Search by Applicant Name</h3>
<form method="post" action="manage.php">
    <input type="text" name="firstName" placeholder="Enter First Name">
    <input type="text" name="lastName" placeholder="Enter Last Name">
    <button type="submit" name="searchByName">Search</button>
</form>
<h3>Delete Applications</h3>
<form method="post" action="manage.php">
    <input type="text" name="deleteJobRef" placeholder="Enter Job Reference to Delete" required>
    <button type="submit" name="deleteEOI">Delete</button>
</form>
<?php require "footer.inc"; ?>
