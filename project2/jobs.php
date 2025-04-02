<?php include 'header.inc'; ?>
<?php include 'menu.inc'; ?>
<link rel="stylesheet" href="./styles/jobsp.css">

<h2>Jobs Description Table</h2>

<?php
// Connect to the database
require_once "settings.php";
$conn = mysqli_connect($host, $user, $password, $database);

if ($conn) {
    $query = "SELECT * FROM `jobs`"; // Query to fetch all jobs
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        // Start the table
        echo "<table border='1'>";
        echo "<thead>
                <tr>
                    <th>Job Reference Number</th>
                    <th>Job Descriptions</th>
                    <th>Benefits</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
              </thead>";
        echo "<tbody>";

        while ($record = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$record['Job Reference Number']}</td>
                    <td>{$record['Job Descriptions']}</td>
                    <td>{$record['Benefits']}</td>
                    <td>\${$record['Salary']}</td>
                    <td>
                    <form action='apply.php' method='post'>
                        <input type='hidden' name='jobnumber' value='{$record['Job Reference Number']}'>
                        <button type='submit'>Apply</button>
                    </form>
                    </td>
                </tr>";}

        echo "</tbody>";
        echo "</table>";


        mysqli_free_result($result);
    } else {
        echo "<p>No jobs found in the database.</p>";
    }

    echo "<p>Connection successful</p>";
    mysqli_close($conn);
} else {
    echo "<p>Connection failed: " . mysqli_connect_error() . "</p>";
}
?>

<?php include 'footer.inc'; ?>
