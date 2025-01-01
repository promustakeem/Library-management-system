<?php
// Start the session
session_start();

// Database connection
$host = 'localhost:3307'; // Ensure the port is correct
$dbname = 'library_mgmt';
$username = 'root';
$password = 'your_password'; // Replace with your actual MySQL root password

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input to avoid unexpected behavior
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Ensure input is not empty
    if (!empty($inputUsername) && !empty($inputPassword)) {
        // Query to check user credentials
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("s", $inputUsername);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($inputPassword, $user['password'])) {
            // Successful login
            $_SESSION['username'] = $user['username'];
            echo "Login successful! Welcome, " . htmlspecialchars($user['username']);
        } else {
            // Failed login
            echo "Invalid username or password.";
        }

        $stmt->close();
    } else {
        echo "Please fill in both fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <form method="POST" action="lo.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>
