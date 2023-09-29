<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $email = $_POST["email"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // Validate that passwords match
    if ($new_password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
    } else {
        // Hash the new password (you may need to use a different hashing method)
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Establish a database connection
        $mysqli = new mysqli("localhost", "root", "", "dissertation");

        if ($mysqli->connect_error) {
            die("Database connection failed: " . $mysqli->connect_error);
        }

        // Update the user's password in the database using their email
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = $mysqli->prepare($sql);

        if (!$stmt) {
            die("Error in prepare statement: " . $mysqli->error);
        }

        $stmt->bind_param("ss", $hashed_password, $email);

        if (!$stmt->execute()) {
            die("Error in SQL execution: " . $stmt->error);
        }

               // Redirect to verify-code.php after the email is sent
               header("Location: login.html");
               exit; // Terminate script execution
        $stmt->close();
        $mysqli->close();
    }
}
?>
