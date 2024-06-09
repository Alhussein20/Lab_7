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

$message = ""; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET name=?, role=? WHERE matric=?");
    $stmt->bind_param("sss", $name, $role, $matric);

    if ($stmt->execute()) {
        $message = "Record updated successfully. <a href='display_users.php'>View users</a>.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $matric = $_GET['matric'];
    $sql = "SELECT matric, name, role FROM users WHERE matric='$matric'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $role = $row['role'];
    } else {
        $message = "No record found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <?php if ($message): ?>
    <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <form action="update_user.php" method="post">
        <h2>Update User</h2>
        <input type="hidden" name="matric" value="<?php echo $matric; ?>">
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" placeholder="Name">
        <select id="role" name="role">
            <option value="student" <?php if ($role == 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if ($role == 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select>
        <input type="submit" value="Update">
        <button type="button" onclick="window.location.href='display_users.php'">Cancel</button>
    </form>
</body>
</html>
