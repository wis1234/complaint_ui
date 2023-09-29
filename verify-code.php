<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$code = $_POST["code"]; // Assuming you only need the code

// Hash the user-entered code using SHA-256
$code_hash = hash("sha256", $code);

// Configure your database connection with your credentials
$mysqli = new mysqli("localhost", "root", "", "dissertation");

// Check for a successful connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Check if the provided code matches any valid code in the database
$sql = "SELECT email
        FROM users
        WHERE reset_token_hash = ? AND reset_token_expires_at >= NOW()";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Error in prepare statement: " . $mysqli->error);
}

$stmt->bind_param("s", $code_hash);

if (!$stmt->execute()) {
    die("Error in SQL execution: " . $stmt->error);
}

$stmt->store_result();
if ($stmt->num_rows > 0) {
    // Code is correct, allow the user to reset their password
        // Redirect to verify-code.php after the email is sent
        header("Location: change-password.html");
        exit; // Terminate script execution
} else {
    // Code is incorrect or expired
    echo "Invalid code or code has expired. Please try again.";
}

// Close the database connection
$mysqli->close();
?>
