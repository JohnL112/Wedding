<?php
$email_to = "johnleonard121@gmail.com"; // replace with your email address
$email_subject = "New Form Submission"; // replace with your desired email subject

// Validate and sanitize input
if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
    die('Please fill out all fields.');
}

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Validate name
if (!preg_match("/^[A-Za-z .'-]+$/", $name)) {
    die('Invalid name format.');
}

// Sanitize email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Invalid email format.');
}

// Sanitize message
function clean_string($string) {
    $bad = array("content-type", "bcc:", "to:", "cc:", "href");
    return str_replace($bad, "", $string);
}

$email_message = "Form details following:\n\n";
$email_message .= "Name: " . clean_string($name) . "\n";
$email_message .= "Email: " . clean_string($email) . "\n";
$email_message .= "Message: " . clean_string($message) . "\n";

// Create email headers
$headers = 'From: ' . $email . "\r\n" .
           'Reply-To: ' . $email . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

if(mail($email_to, $email_subject, $email_message, $headers)) {
    echo 'Thanks for contacting us, we will get back to you as soon as possible.';
} else {
    echo 'There was a problem sending the email.';
}
?>
