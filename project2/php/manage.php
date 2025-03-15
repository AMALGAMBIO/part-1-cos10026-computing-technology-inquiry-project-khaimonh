
<?php 

session_start(); // Start the session, creates $_SESSION

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { //if $_SESSION is not set or not true
    header("Location: login.php"); // Redirect to login page if not logged in
    exit; 
}
    include 'header.inc';
    include 'menu.inc';
    require 'settings.php' ?>
<h3>All Applications</h3>
<div id="allEOIs">
    <!-- PHP script will load all applications here -->
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
