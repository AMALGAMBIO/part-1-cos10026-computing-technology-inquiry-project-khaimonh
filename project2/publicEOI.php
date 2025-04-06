<?php
include 'header.inc';
include 'manage.inc';   
require_once 'settings-manage.php';
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
        echo "<table class='EOITable' style=';'>";
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
            echo "<td>" . $row["EOI_id"] . "</td>";
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
}?>
<nav>
    <a href="index.php" class="home">BITBOPS</a>
</nav>
<div class="publicSearch" style="display: flex; align-items:flex-start; flex-direction: column; justify-content: center; width: 95%;">
    <h2>Enter your email to view your Application: </h2>
    <form method="post" action="publicEOI.php">
        <input type="text" name="emailSearch" placeholder="Enter email" required>
        <button type="submit" name="publicSearchEmail">Search</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["publicSearchEmail"])) {
        $email = trim($_POST["emailSearch"]);
        echo "Email entered: " . htmlspecialchars($email) . "<br>";

        $query = "SELECT * FROM eoi WHERE Email = ?";
        echo "Executing query: " . $query . "<br>";

        fetchAndDisplayEOIs($conn, $query, ["s", $email]);
    }
    ?>
</div>
<?php require "footer.inc"; ?>