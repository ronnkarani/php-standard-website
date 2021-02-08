<?php
session_start();
require '../mdb/php/db_connect.php';
require '../mdb/php/utils.php';

$username = $_POST['username'];
$website = $_POST['website'];
$senderMail = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

if(isset($_SESSION['logged_in_userid'])){
    $sql = "SELECT users.website, users.email, users.username FROM users WHERE id = ".$_SESSION['logged_in_userid']."";
    $users = executer($sql);
    $user = $users[0];
    $username = $user['username'];
    $senderMail = $user['email'];
    $website = $user['website'];
}

$mailBody = "You have received an email from:\nName: " . $username . "\nWebsite: " .$website. "\n\n" . $message;

date_default_timezone_set('Etc/UTC');

// Edit this path if PHPMailer is in a different location.
require '../mdb/PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();

/*
* Server Configuration
*/

$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
$mail->Username = "comradeswriter@gmail.com"; // Your Gmail address.
$mail->Password = "Dennis@123"; // Your Gmail login password or App Specific Password.

/*
* Message Configuration
*/

$mail->setFrom('comradeswriter@gmail.com', 'Comrades Academic Solutions'); // Set the sender of the message.
$mail->addAddress('comradeswriter@gmail.com', 'Comradeswriter1'); // Set the recipient of the message.
$mail->ClearReplyTos();
$mail->addReplyTo($senderMail, $username);
$mail->Subject =  $subject; // The subject of the message.

/*
* Message Content - Choose simple text or HTML email
*/

// Choose to send either a simple text email...
$mail->Body = $mailBody; // Set a plain text body.

//add attachment
if(!empty($_FILES['file'])){
    $file_tmp  = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    //...
    $mail->AddAttachment($file_tmp, $file_name);
}

if ($mail->send()) {
            $mail1 = new PHPMailer;
            $mail1->isSMTP();
            $mail1->Host = 'smtp.gmail.com'; // Which SMTP server to use.
            $mail1->Port = 587; // Which port to use, 587 is the default port for TLS security.
            $mail1->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
            $mail1->SMTPAuth = true; // Whether you need to login. This is almost always required.
            $mail1->Username = "comradeswriter@gmail.com"; // Your Gmail address.
            $mail1->Password = "Dennis@123"; // Your Gmail login password or App Specific Password.
            $mail1->setFrom('comradeswriter@gmail.com', 'Comrades Academic Solutions'); // Set the sender of the message.
            $mail1->ClearReplyTos();
            $mail1->addReplyTo('comradeswriter@gmail.com', 'Comradeswriter1');
            $mail1->addAddress($senderMail, $username); // Set the recipient of the message.
            $mail1->Subject =  'Message Received'; // The subject of the message.
            $mail1->Body = 'Hello '. $username . ', We have received your message. Thank you for contacting us.';
            $mail1->send();
            
            exit("message_sent");
        } else {
        // echo "Mailer Error: " . $mail->ErrorInfo;
        exit($mail->ErrorInfo);
        }