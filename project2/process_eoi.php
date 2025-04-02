<?php
include 'header.inc';
include 'menu.inc';
?>
<link rel="stylesheet" href="styles/process_eoi.css">

<main>
<h2>Welcome to the EOI records page. <br> Here you can view all the records submitted through the apply form.</h2>


<?php
// Connect to the database
require_once "settings.php";
$conn = mysqli_connect($host, $user, $password, $database);

if ($conn) {
    $query = "SELECT * FROM `eoi`"; // Query to fetch all EOI records
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th>Job Reference Number</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Phone Number</th>
                    <th>Street Address</th>
                    <th>Suburb Town</th>
                    <th>State</th>
                    <th>Email Address</th>
                    <th>CV Images</th>
                    <th>Other Skills</th>
                </tr>
              </thead>";
        echo "<tbody>";

        // Fetch and display each record
        while ($record = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$record['Job Reference Number']}</td>
                    <td>{$record['First Name']}</td>
                    <td>{$record['Last Name']}</td>
                    <td>{$record['Gender']}</td>
                    <td>{$record['Phone number']}</td>
                    <td>{$record['Street Address']}</td>
                    <td>{$record['Suburb Town']}</td>
                    <td>{$record['State']}</td>
                    <td>{$record['Email Address']}</td>
                    <td>{$record['CV images']}</td>
                    <td>{$record['Other Skills']}</td>
                  </tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Free the result set
        mysqli_free_result($result);
    } else {
        echo "<p>No records found in the database.</p>";
    }

    echo "<p>Connection successful</p>";
    mysqli_close($conn);
} else {
    echo "<p>Connection failed: " . mysqli_connect_error() . "</p>";
}
?>
</main>

<?php require "footer.inc"; ?>

