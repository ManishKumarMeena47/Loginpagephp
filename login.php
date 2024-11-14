<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "user_system"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $username_or_email = $_POST['username'];
    $password = $_POST['password'];

    // Query to find user by username or email
    $sql = "SELECT * FROM users WHERE username='$username_or_email' OR email='$username_or_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, check password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "Login successful! Welcome " . $_SESSION['username'];
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $conn->close();
}
?>
