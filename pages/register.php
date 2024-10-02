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
    if (empty($errors)) {
        $checkUsername = $pdo->prepare("SELECT * FROM Customer WHERE Username = :username");
        $checkUsername->execute([':username' => $username]);

        if ($checkUsername->rowCount() > 0) {
            $errors[] = "Username already taken. Please choose another.";
        }
    }

    // Check if email is already registered
    if (empty($errors)) {
        $checkEmail = $pdo->prepare("SELECT * FROM Customer WHERE Email = :email");
        $checkEmail->execute([':email' => $email]);

        if ($checkEmail->rowCount() > 0) {
            $errors[] = "Email already registered. Please choose another.";
        }
    }

    // If no errors, then insert into the database
    if (empty($errors)) {
        $newCustomerID = mt_rand(1000, 9999);

        // Insert the user into the database without hashing the password
        $sql = "INSERT INTO Customer (CustomerID, FirstName, LastName, Email, Username, Password) 
VALUES (:customer_id, :first_name, :last_name, :email, :username, :password)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':customer_id' => $newCustomerID,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':username' => $username,
            ':password' => $password // Store the plain text password
        ]);

        if ($result) {
            // Generate a random OTP
            $otp = random_int(100000, 999999);

            // Store the OTP and its expiry time (5 minutes)
            $expiryTime = date('Y-m-d H:i:s', strtotime('+5 minutes'));
            $updateSQL = "UPDATE Customer SET OTP = :otp, OTP_Expiry = :otp_expiry WHERE CustomerID = :customer_id";
            $updateStmt = $pdo->prepare($updateSQL);
            $updateStmt->execute([
                ':otp' => $otp,
                ':otp_expiry' => $expiryTime,
                ':customer_id' => $newCustomerID
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
}

if (!empty($error)) {
    header("Location: ../index.php?error=" . urlencode($error));
    exit;
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>

    <h2>Register</h2>

    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Register</button>
    </form>

</body>

</html>