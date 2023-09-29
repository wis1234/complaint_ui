<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$email = $_POST["email"];

// Generate a random 6-digit code
$code = sprintf('%06d', mt_rand(0, 999999));

// Hash the code for storage in the database
$code_hash = hash("sha256", $code);

// Set the time zone to Benin (UTC+1)
date_default_timezone_set('Africa/Porto-Novo');

// Calculate the expiration time as 30 minutes from now
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

// Configure your database connection with your credentials
$mysqli = new mysqli("localhost", "root", "", "dissertation");

// Check for a successful connection
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Prepare and execute the SQL statement with the correct table name "users"
$sql = "UPDATE users
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    die("Error in prepare statement: " . $mysqli->error);
}

$stmt->bind_param("sss", $code_hash, $expiry, $email);

if (!$stmt->execute()) {
    die("Error in SQL execution: " . $stmt->error);
}

if ($stmt->affected_rows) {

    // Include the PHPMailer library
    require __DIR__ . "/vendor/autoload.php";

    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    // Configure SMTP settings
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = "smtp.gmail.com"; // Gmail SMTP server
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;
    $mail->Username = "ronaldoagbohou@gmail.com";
    $mail->Password = "vivm mkdk xpba rnon"; // Your Gmail password

    // Set email content
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Password Reset";
    $mail->isHtml(true);
    $mail->Body = <<<END
    Your password reset code is: $code
    END;

    try {
        // Send the email
        $mail->send();
        // Redirect to verify-code.php after the email is sent
        header("Location: send-verification-code.html");
        exit; // Terminate script execution
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }

} else {
    echo "Email not found or database error.";
}

// Close the database connection
$mysqli->close();

?>
