<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Lab_7";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$matric = $_GET['matric'];

$stmt = $conn->prepare("DELETE FROM users WHERE matric=?");
$stmt->bind_param("s", $matric);

if ($stmt->execute()) {
    echo "Record deleted successfully. <a href='display_users.php'>View users</a>.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
</body>
</html>
