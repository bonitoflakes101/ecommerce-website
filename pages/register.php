<?php
session_start();
require '../includes/db_config.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username is taken
    $checkUsername = $pdo->prepare("SELECT * FROM Customer WHERE Username = :username");
    $checkUsername->execute([':username' => $username]);

    if ($checkUsername->rowCount() > 0) {
        $errors[] = "Username already taken";
    }

    // Check if email is already registered
    $checkEmail = $pdo->prepare("SELECT * FROM Customer WHERE Email = :email");
    $checkEmail->execute([':email' => $email]);

    if ($checkEmail->rowCount() > 0) {
        $errors[] = "Email already registered.";
    }

    if (empty($errors)) {
        $newCustomerID = mt_rand(1000, 9999);

        $sql = "INSERT INTO Customer (CustomerID, FirstName, LastName, Email, Username, Password) 
                VALUES (:customer_id, :first_name, :last_name, :email, :username, :password)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':customer_id' => $newCustomerID,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':username' => $username,
            ':password' => $password
        ]);

        if ($result) {
            $otp = random_int(100000, 999999);

            // FIX EXPIRY TIME, NOT WORKING LMAO
            $expiryTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $updateSQL = "UPDATE Customer SET OTP = :otp, OTP_Expiry = :otp_expiry WHERE CustomerID = :customer_id";
            $updateStmt = $pdo->prepare($updateSQL);
            $updateStmt->execute([
                ':otp' => $otp,
                ':otp_expiry' => $expiryTime,
                ':customer_id' => $newCustomerID
            ]);

            // prep email
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'xiangendonila@gmail.com'; // your email
                $mail->Password = 'ylwiokagsdabaqye';        // app password
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                $mail->SMTPDebug = 0;

                // Recipients
                $mail->setFrom('xiangendonilax@gmail.com', 'Reset Password');
                $mail->addAddress($email, 'User');

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Account Verification';
                $mail->Body = "Your OTP is: $otp. It will expire in 5 minutes.";

                $mail->send();

                // Store email value for use in verify_otp
                $_SESSION['email'] = $email;
                header("Location: verify_otp.php");
                exit;
            } catch (Exception $e) {
                $errors[] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

    // If there are errors, redirect to index.php and display errors
    if (!empty($errors)) {
        $errorString = urlencode(implode(', ', $errors));
        header("Location: ../index.php?register_error=" . $errorString);
        exit;
    }
}
