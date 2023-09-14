<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $captchaInput = $_POST["captchaInput"];
    $captchaText = $_POST["captchaText"];

    // Validate CAPTCHA
    if ($captchaInput === $captchaText) {
        // Send confirmation email
        $to = $email;
        $subject = "Form Submission Confirmation";
        $message = "Thank you for submitting the form!\n\n"
                 . "Name: $name\n"
                 . "Contact: $contact\n"
                 . "Email: $email\n";
        $headers = "From: iftikharbq@gmail.com"; // Change this to your actual email address

        if (mail($to, $subject, $message, $headers)) {
            echo "Form submitted successfully. You will receive a confirmation email.";
        } else {
            echo "Error sending email. Please try again later.";
        }
    } else {
        echo "Invalid CAPTCHA. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>