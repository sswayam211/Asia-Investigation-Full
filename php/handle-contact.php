<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = mysqli_connect("localhost", "root", "", "asia_investigation");

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contact (`NAME`, `EMAIL`, `MESSAGE`) VALUES ('$name', '$email', '$message')";
    $result = mysqli_query($conn, $sql);

    if ($result) {

        // sending mail 

        require '../vendor/autoload.php'; // Path to Composer's autoloader

        $mail = new PHPMailer(true); // Enable exceptions

        try {
            // Server settings
            $mail->isSMTP(); // Send using SMTP
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true; // Enable SMTP authentication
            $mail->Username   = 'sswayam211@gmail.com'; // SMTP username
            $mail->Password   = 'oyqg umpy iwhe vxak'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587; // TCP port to connect to

            // Recipients
            $mail->setFrom('sswayam211@gmail.com', 'Asia Investigation Services');
            $mail->addAddress('sswayam1112@gmail.com', 'Swayam Singh'); // Add a recipient

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'New Contact Form Submission';
            $mail->Body    = 'You have received a new contact form submission from <br> <br>
                                <b>Name:</b> ' . $name . '.<br><b>Email:</b> ' . $email . '<br><b>Message:</b> ' . nl2br($message);
            $mail->AltBody = 'You have received a new contact form submission from ' . $name . '. Email: ' . $email . ' Message: ' . $message;

            $mail->send();
            echo 'Message has been sent';

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

        }

        // Redirecting to index page with success message
        header("Location: /KundanPro/Asia%20Investigation%20Services%20website/index.php?s=1#contact-form");
        exit();
    } else {
        header("Location: /KundanPro/Asia%20Investigation%20Services%20website/index.php?s=0#contact-form");
        exit();
    }


    $conn->close();
}
