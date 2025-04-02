<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start(); // Start the session, creates $_SESSION
// // Check if the user is logged in
// if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { //if $_SESSION is not set or not true
//     header("Location: login-enhancement.php"); // Redirect to login page if not logged in
//     exit; }
include 'header.inc';
include 'manage.inc';   
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
<nav>
    <a href="index.php" class="home">BITBOPS</a>
</nav>

<div id="allEOIs">
    <h3>All Applications</h3>
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
    echo "<p>Number of rows found: " . $result->num_rows . "</p><br>";

    if ($result->num_rows > 0) {
        echo "<table class='EOITable'>";
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
            echo "<td><a href='mailto:" . htmlspecialchars($row["Email"]) . "'>" . htmlspecialchars($row["Email"]) . "</a></td>";
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
function deleteEOI($conn, $jobRef) {
    // Debug: Display the JobRef to be deleted
    echo "JobRef to delete: " . htmlspecialchars($jobRef) . "<br>";

    // Prepare the DELETE query
    $query = "DELETE FROM eoi WHERE JobRef = ?";
    $stmt = $conn->prepare($query);
    
    echo "Executing query: " . $query . "<br>";

    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }

    // Bind the parameter and execute the query
    $stmt->bind_param("s", $jobRef);
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->affected_rows > 0) {
            echo "EOI with JobRef " . htmlspecialchars($jobRef) . " has been deleted successfully.<br>";
        } else {
            echo "No EOI found with JobRef " . htmlspecialchars($jobRef) . ".<br>";
        }
    } else {
        echo "Error deleting EOI: " . $stmt->error . "<br>";
    }

    $stmt->close();
}
$query = "SELECT * FROM eoi ORDER BY EOInumber ASC";
fetchAndDisplayEOIs($conn, $query);
?>
</div>
<div class="container">
    <div class="refSearch">
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
    </div>
    <div class="nameSearch">
        <h3>Search by Applicant Name</h3>
        <form class="" method="post" action="manage.php">
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
            $query = "SELECT * FROM eoi WHERE FirstName = ? or LastName = ? ORDER BY EOInumber ASC";
            echo "Executing query: " . $query . "<br>";
    
            fetchAndDisplayEOIs($conn, $query, ["ss", $firstName, $lastName]);
        }
        ?>
    </div>
    <div class="deleteEOI">
        <h3>Delete Applications</h3>
        <form method="post" action="manage.php">
          <input type="text" name="deleteJobRef" placeholder="Enter Job Reference to Delete" required>
            <button type="submit" name="confirmDeleteEOI">Delete</button>
        </form>
    
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirmDeleteEOI"])){
            $jobRef = trim($_POST["deleteJobRef"]);
            echo "<h4>Confirm Deletion</h4>";
            echo "<p>Are you sure you want to delete the EOI with Job Reference: " . htmlspecialchars($jobRef) . "?</p>";
            echo '<form method="post" action="manage.php">';
            echo '<input type="hidden" name="deleteJobRef" value="' . htmlspecialchars($jobRef) . '">';
            echo '<button type="submit" name="deleteEOI">Yes, Delete</button>';
            echo '<button type="submit" name="cancelDelete">Cancel</button>';
            echo '</form>';
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteEOI"])) {
            $jobRef = trim($_POST["deleteJobRef"]);
            deleteEOI($conn, $jobRef);
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancelDelete"])) {
            echo "<p>Deletion canceled.</p>";
        }
        ?>
    </div>
    
    <div class="changeStatus">
        <h3>Change EOI Status</h3>
        <form method="post" action="manage.php">
            <input type="text" name="statusJobRef" placeholder="Enter Job Reference" required>
            <label for="newStatus">Select New Status:</label>
            <select name="newStatus" id="newStatus" required>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
            <button type="submit" name="updateStatus">Update Status</button>
        </form>
    
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["updateStatus"])) {
            $jobRef = trim($_POST["statusJobRef"]);
            $newStatus = trim($_POST["newStatus"]);
    
            // Debug: Display the JobRef and new status
            echo "JobRef to update: " . htmlspecialchars($jobRef) . "<br>";
            echo "New Status: " . htmlspecialchars($newStatus) . "<br>";
    
            // Prepare the UPDATE query
            $query = "UPDATE eoi SET Status = ? WHERE JobRef = ?;";
            $stmt = $conn->prepare($query);
    
            if (!$stmt) {
                die("Query preparation failed: " . $conn->error);
            }
    
            // Bind the parameters and execute the query
            $stmt->bind_param("ss", $newStatus, $jobRef);
            if ($stmt->execute()) {
                // Check if any rows were affected
                if ($stmt->affected_rows > 0) {
                    echo "Status for EOI with JobRef " . htmlspecialchars($jobRef) . " has been updated to " . htmlspecialchars($newStatus) . ".<br>";
                } else {
                    echo "No EOI found with JobRef " . htmlspecialchars($jobRef) . ".<br>";
                }
            } else {
                echo "Error updating status: " . $stmt->error . "<br>";
            }
    
            $stmt->close();
        }
        ?>
    </div>
</div>

<?php require "footer.inc"; 

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
?>