<?php
session_start(); // Start the session

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
    $password = $_POST['password'];

    // Validate input
    if (empty($matric) || empty($password)) {
        echo "All fields are required.";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("SELECT password FROM users WHERE matric = ?");
        $stmt->bind_param("s", $matric);
        
        // Execute the statement
        $stmt->execute();
        $stmt->store_result();
        
        // Check if user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            
            // Verify password
            if (password_verify($password, $hashed_password)) {
                // Set session variable
                $_SESSION['loggedin'] = true;
                $_SESSION['matric'] = $matric;
                header("Location: display_users.php");
                exit();
            } else {
                echo "Invalid username or password, try <a href='login.php'>login</a> again.";
            }
        } else {
            echo "Invalid username or password, try <a href='login.php'>login</a> again.";
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
