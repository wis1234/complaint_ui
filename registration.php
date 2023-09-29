<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that required fields are set in the form data
    $requiredFields = ['firstname', 'lastname', 'email', 'phone', 'matricule', 'password'];
    $isDataValid = true;

    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            echo "Error: $field is required.";
            $isDataValid = false;
            break; // Stop validation on the first missing field
        }
    }

    if ($isDataValid) {
        $formData = [
            'firstname' => $_POST['firstname'],
            'lastname' => $_POST['lastname'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'mat_number' => $_POST['matricule'],
            'password' => $_POST['password']
            // Add other fields as needed
        ];

        // Prepare the cURL request
        $ch = curl_init('http://127.0.0.1:8001/api/users'); // Replace with your API endpoint URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($formData));

        // Execute the cURL request
        $response = curl_exec($ch);

        // Handle the response
        if ($response === false) {
            echo 'Error sending request';
        } else {
            echo 'API Response: ' . $response;
        }

        // Close cURL session
        curl_close($ch);
    }
}
?>
