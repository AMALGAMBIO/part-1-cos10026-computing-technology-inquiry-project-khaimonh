<?php include 'header.inc'; ?>
<?php include 'menu.inc'; ?>
<link rel="stylesheet" href="./styles/jobs.css" />

<h2> Jobs Description table</h2>

<?php

//Connect to database
require_once "settings.php";
$conn = mysqli_connect("$host", "$user", "$password", "$database");
if($conn) {
  $query = "SELECT * FROM `jobs`";                                   //Insert query
  $result = mysqli_query ($conn, $query);
if ($result) {
    $record = mysqli_fetch_assoc($result);
    echo "<table border='1'>";
    echo "<tr>
    <th>ID</th>
    <th>Job Reference Number</th>
    <th>Job Description</th>
    <th>Salary</th></tr>";

while($record) {
    echo "<tr><td>{$record['jobs_id']}</td>";
    echo "<td>{$record['Job Reference Number']}</td>";
    echo "<td>{$record['Job Description']}</td>";
    echo "<td>{$record['Salary']}</td>";
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

?>

<?php include 'footer.inc'; ?>
