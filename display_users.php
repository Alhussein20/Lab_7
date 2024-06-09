<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

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

// SQL query to fetch data from the users table
$sql = "SELECT matric, name, role AS accessLevel FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>User List</h2>
        <?php
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Matric</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>";
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["matric"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["accessLevel"] . "</td>
                        <td>
                            <a href='update_user.php?matric=" . $row["matric"] . "'>Update</a>
                            <a href='delete_user.php?matric=" . $row["matric"] . "'>Delete</a>
                        </td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        // Close connection
        $conn->close();
        ?>
    </div>
</body>
</html>
