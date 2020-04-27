<?php
/* Assumes that PHPMailer is installed in the Root Directory of the project */
/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


/* Assumes source files are copied into PHPMAiler directory */

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/* If you installed PHPMailer using composer or once click install do this instead: */

/* require './vendor/autoload.php'; */

function sendVerificationMail($userEmail, $token) /* Function that is called from notVerified.php and signup.php */
    
{

/* Create a new PHPMailer object. Passing TRUE to the constructor enables exceptions. */
$mail = new PHPMailer(TRUE);

/* Open the try/catch block. */
try {
   /* Set the mail sender. */
   $mail->setFrom('SOMEONE@SOMEDOMAIN.COM', 'SENDER_NAME'); 

   /* Add a recipient. */
   $mail->addAddress($userEmail);

   /* Set the subject. */
   $mail->Subject = 'Please Verify your E-Mail Address';

   /* Set the mail message body. */
    $mail->isHTML(TRUE); // Set an HTML Message
    /* Next Compose HTML e-mail */
    $mail->Body = '
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <title>Test mail</title>
      <style>
        .wrapper {
          padding: 20px;
          color: #444;
          font-size: 1.3em;
        }
        a {
          background: #592f80;
          text-decoration: none;
          padding: 8px 15px;
          border-radius: 5px;
          color: #fff;
        }
      </style>
    </head>

    <body>
      <div class="wrapper">
        <p>Thank you for signing up on our site. Please click on the link below to verify your account:.</p>
        <a href="YOUR_URL/verifyMail.php?token=' . $token . '">Verify Email!</a>
      </div>
    </body>

    </html>';
    
    /* Set alternative body for mail not supporting HTML */
    
    $mail->AltBody = 'Thank you for signing up on our site. Please copy and paste the following link in your browser to verify your account: "YOUR_URL/verifyMail.php?token=' . $token . '"';
    

    /* SMTP parameters. */
   
   /* Tells PHPMailer to use SMTP. */
   $mail->isSMTP(); /* If you want to use the internal php mail() function, omit this and the SMTP setup */
   
   /* SMTP server address. */
   $mail->Host = 'smtp.server.com';

   /* Use SMTP authentication. */
   $mail->SMTPAuth = TRUE;
   
   /* Set the encryption system. */
   $mail->SMTPSecure = 'tls';
   
   /* SMTP authentication username. */
   $mail->Username = 'mail@server.com';
   
   /* SMTP authentication password. */
   $mail->Password = 'mail_password';
   
   /* Set the SMTP port. */
   $mail->Port = 587;

   /* Finally send the mail. */
   $mail->send();
}
catch (Exception $e)
{
   /* PHPMailer exception. */
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   /* PHP exception (note the backslash to select the global namespace Exception class). */
   echo $e->getMessage();
}

}

?>
