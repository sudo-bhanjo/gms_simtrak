<?php

$mysqli = new mysqli("localhost","root","","goal");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

$query = "SELECT * FROM users";
$result = $mysqli->query($query);
if ($result->num_rows > 0) {
    // Fetch the result as an associative array
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    // Print the contents using print_r
    echo "<pre>";
    print_r($rows);
    echo "</pre>";
} else {
    echo "0 results";
}

// Close the connection
$mysqli->close();
?>

?>