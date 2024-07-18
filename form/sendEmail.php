<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function checkEmailProvider($email) {
    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
    }

    // Extract the domain from the email
    $domain = substr(strrchr($email, "@"), 1);

    // Check the domain against known providers
    switch ($domain) {
        case 'gmail.com':
            return "Gmail";
        case 'outlook.com':
        case 'hotmail.com':
            return "Outlook";
        default:
            return "Other";
    }
}
$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $Port = 0; //Port required

    // Validate the form data
    if (empty($name) || empty($email) || empty($message)) {
        // Return an error response
        $response = ['error' => 'All fields are required'];
        http_response_code(400);
        echo json_encode($response);
        exit;
    }

    //Server settings
    try {
        /*
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.server.com'; //SMTP server host
        $mail->SMTPAuth   = true;
        $mail->Username   = 'aeroastro_vzg@gitam.in';
        $mail->Password   = 'Your_Password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $Port;
        */
        //Recipients
        $mail->setFrom($email, 'Mailer');
        $mail->addAddress('pskparthiv@gmail.com', 'Hello');
    
        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    
} else {
    // Return an error response for non-POST requests
    $response = ['error' => 'Invalid request method'];
    http_response_code(405);
    echo json_encode($response);
}
?>