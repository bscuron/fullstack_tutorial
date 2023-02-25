<?php
ini_set('display_errors', 1);
session_start();
require_once('config.php');

// Get POST data
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

// Create connection
$conn = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert into database
$stmt = $conn->prepare("INSERT INTO Users2 (firstname, lastname) VALUES (?, ?)");
$stmt->bind_param("ss", $firstname, $lastname);
$result = $stmt->execute();
$stmt->close();

// Check result
if ($result === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Get database contents
$result = $conn->query("SELECT * FROM Users2");

if ($result->num_rows > 0) {
    echo "<hr>";
    echo "<table>";
    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "</tr>";
    while($row = $result->fetch_assoc()){
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["firstname"] . "</td>";
        echo "<td>" . $row["lastname"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Database is empty";
}
    
// Close connection
$conn->close();
?>
