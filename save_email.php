<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email from POST request
    $data = json_decode(file_get_contents('php://input'), true);
    $email = $data['email'];

    // Check if email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Read existing emails
        $file = 'all-mails.json';
        $emails = [];

        if (file_exists($file)) {
            $emails = json_decode(file_get_contents($file), true);
        }

        // Add new email to the list
        $emails[] = $email;

        // Save the updated emails array back to the file
        file_put_contents($file, json_encode($emails, JSON_PRETTY_PRINT));

        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
