<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Change as per your database username
$password = ""; // Change as per your database password
$dbname = "Lab_7"; // Change as per your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $matric = $_POST['matric'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validate input
    if (empty($matric) || empty($name) || empty($password) || empty($role)) {
        echo "All fields are required.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $matric, $name, $hashed_password, $role);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New record created successfully. <a href='login.php'>Login here</a>.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form action="register.php" method="post">
        <h2>Registration Form</h2>
        <input type="text" id="matric" name="matric" placeholder="Matric">
        <input type="text" id="name" name="name" placeholder="Name">
        <input type="password" id="password" name="password" placeholder="Password">
        <select id="role" name="role">
            <option value="">Please select</option>
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select>
        <input type="submit" value="Submit">
        <a href="login.php">Already registered? <span>Login here</span></a>
    </form>
</body>
</html>
