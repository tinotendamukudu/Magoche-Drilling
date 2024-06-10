<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $message = $_POST["message"];

    // Initialize error array
    $errors = [];

    // Validate form data
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    // If there are validation errors, display them and stop further processing
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
        }
        exit; // Stop further processing
    }

    // If all validations pass, send the email
    $subject = "New Form Submission";
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";

    // Your email address to receive the form submissions
    $to = "mukudutinotenda@gmail.com";

    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Gmail SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mukudutinotenda@gmail.com'; // Your Gmail address
        $mail->Password   = 'lvrn rsas kppe mdil'; // Your Gmail password or App password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port       = 587; // TCP port to connect to

        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        // echo '<div class="alert alert-success" role="alert">Form submitted successfully! Your message has been sent.</div>';

    } catch (Exception $e) {
        echo '<div class="alert alert-danger" role="alert">';
        echo 'Error sending the email. Please try again later. Error: ' . $mail->ErrorInfo;
        echo '</div>';
    }

} else {
    // If the form is accessed directly, redirect to the homepage or display an error message
    header("Location: /index.html");
    exit;
}

?>
