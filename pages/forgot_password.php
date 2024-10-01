<?php
session_start();
require '../includes/db_config.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        // check if email exists in the database
        $checkEmail = $pdo->prepare("SELECT * FROM Customer WHERE Email = :email");
        $checkEmail->execute([':email' => $email]);

        if ($checkEmail->rowCount() == 0) {
            $errors[] = "Email not found.";
        }
    }

    // if no error, generate and send OTP
    if (empty($errors)) {
        // Generate random OTP
        $otp = random_int(100000, 999999);
        $expiryTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Update Customer table with OTP and expiry time
        $updateSQL = "UPDATE Customer SET OTP = :otp, OTP_Expiry = :otp_expiry WHERE Email = :email";
        $updateStmt = $pdo->prepare($updateSQL);
        $updateStmt->execute([
            ':otp' => $otp,
            ':otp_expiry' => $expiryTime,
            ':email' => $email
        ]);

        // Prepare email for sending
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'xiangendonila@gmail.com'; // your email
            $mail->Password = 'ylwiokagsdabaqye';     // app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPDebug = 0;

            // Recipients
            $mail->setFrom('xiangendonilax@gmail.com', 'Reset Password');
            $mail->addAddress($email, 'User');

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP for Password Reset';
            $mail->Body = "Your OTP is: $otp. It will expire in 5 minutes.";

            $mail->send();

            // Store email in session to use in verify_pass_otp.php
            $_SESSION['reset_email'] = $email;
            header("Location: verify_pass_otp.php");
            exit;
        } catch (Exception $e) {
            $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <h1>Forgot Password</h1>
    <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send OTP</button>
    </form>
    <?php if (!empty($errors)): ?>
        <div><?php echo implode('<br>', $errors); ?></div>
    <?php endif; ?>
</body>

</html>