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
    $contactNumber = trim($_POST['contact_number']);
    $fullAddress = trim($_POST['full_address']);

    // Validate contact number (Philippines format)
    if (!preg_match('/^(0[9][0-9]{9})$/', $contactNumber)) {
        $errors[] = "Invalid contact number. Must be in the format: 09XXXXXXXXX.";
    }

    // Check if username is taken
    $checkUsername = $pdo->prepare("SELECT * FROM Customer WHERE Username = :username");
    $checkUsername->execute([':username' => $username]);

    if ($checkUsername->rowCount() > 0) {
        $errors[] = "Username already taken";
    }

    // checks email if alr registered
    $checkEmail = $pdo->prepare("SELECT * FROM Customer WHERE Email = :email");
    $checkEmail->execute([':email' => $email]);

    if ($checkEmail->rowCount() > 0) {
        $errors[] = "Email already registered.";
    }

    if (empty($errors)) {
        do {
            $newCustomerID = mt_rand(1000, 9999);

            // prevents duplicate ng cx id
            $checkCustomerID = $pdo->prepare("SELECT * FROM Customer WHERE CustomerID = :customer_id");
            $checkCustomerID->execute([':customer_id' => $newCustomerID]);
        } while ($checkCustomerID->rowCount() > 0);


        $sql = "INSERT INTO Customer (CustomerID, FirstName, LastName, Email, Username, Password, FullAddress, ContactDetails) 
                VALUES (:customer_id, :first_name, :last_name, :email, :username, :password, :full_address, :contact_number)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':customer_id' => $newCustomerID,
            ':first_name' => $firstName,
            ':last_name' => $lastName,
            ':email' => $email,
            ':username' => $username,
            ':password' => $password,
            ':full_address' => $fullAddress,
            ':contact_number' => $contactNumber
        ]);

        if ($result) {
            // creates a cart for the new customer
            $cartSQL = "INSERT INTO Cart (CustomerID) VALUES (:customer_id)";
            $cartStmt = $pdo->prepare($cartSQL);
            $cartStmt->execute([':customer_id' => $newCustomerID]);

            $otp = random_int(100000, 999999);
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
                $mail->setFrom('xiangendonilax@gmail.com', 'Verify Account');
                $mail->addAddress($email, 'User');

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your OTP for Account Verification';
                $mail->Body = "Your OTP is: $otp. It will expire in 5 minutes.";

                $mail->send();

                // Store email value for use in verify_otp
                $_SESSION['email'] = $email;
                header("Location: ../index.php?confirm_email=true");
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
