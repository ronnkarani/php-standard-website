<?php
require './db_connect.php';
require './utils.php';

try {
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email ='$email'";
    $users = executer($sql);
    if (count($users) > 0) {

        $letters = array('6', '7', '8', '9', '0', '&', 'A', 'a', 'B', 'b', 'C', 'c', 'D', 'd', 'E', 'e', 'F', 'f', 'G', 'g', 'H', 'h','K', 'k', 'L', 'M', 'm', 'N', 'n', 'O', 'o', 'P', 'p', 'Q', 'q', 'R', 'r', 'S', 's', 'T', 't', 'U', 'u', 'V', 'v', 'W', 'w', 'X', 'x', 'Y', 'y', 'Z', 'z', '1', '2', '3', '4', '5');
        $password = '';
        for ($x = 0; $x <= 8; $x++) {
            $index = rand(0, (count($letters) - 1));
            $password .= $letters[$index];
        }
        $encrypted_password = md5($password);

        date_default_timezone_set('Etc/UTC');

        // Edit this path if PHPMailer is in a different location.
        require '../PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();

        // /*
        // * Server Configuration
        // */

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
        $mail->addAddress($email, $users[0]['username']); // Set the recipient of the message.
        $mail->Subject = 'Recover password'; // The subject of the message.

        /*
        * Message Content - Choose simple text or HTML email
        */

        $mail->Body = 'Hi '.$users[0]['username'].'You requested to change your password. Your new password is: '.$password.' .Please proceed to your profile and change this password to your suitable password.
        ';
        // $mail->IsHTML(true);

        if ($mail->send()) {
            $sql = "UPDATE users SET password='$encrypted_password' WHERE email='$email'";
                    noResultQuery($sql);
                    exit("sent");
        } else {
        // echo "Mailer Error: " . $mail->ErrorInfo;
        exit('failed');
        }
    }
    else {
        exit('not_found');
    }

} catch (PDOException $e) {
    exit($e->getMessage());
}