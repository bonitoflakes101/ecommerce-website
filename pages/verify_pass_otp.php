<?php
session_start();
require '../includes/db_config.php';

// Prevent direct access without reset email
if (!isset($_SESSION['reset_email'])) {
    header("Location: ../index.php");
    exit;
}

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = trim($_POST['otp']);
    $newPassword = trim($_POST['new_password']);
    $email = $_SESSION['reset_email']; // Get the email from the forgot_password file

    // Check if all fields are filled
    if (empty($otp) || empty($newPassword)) {
        $errors[] = "All fields are required.";
    }

    // Password validation
    if (empty($newPassword)) {
        $errors[] = "Password cannot be empty.";
    } else {
        if (strlen($newPassword) < 8) {
            $errors[] = "Password must be at least 8 characters long";
        }
        if (!preg_match("/[A-Z]/", $newPassword)) {
            $errors[] = "Password must contain at least one uppercase letter";
        }
        if (!preg_match("/[a-z]/", $newPassword)) {
            $errors[] = "Password must contain at least one lowercase letter";
        }
        if (!preg_match("/[0-9]/", $newPassword)) {
            $errors[] = "Password must contain at least one number";
        }
        if (!preg_match("/[\W_]/", $newPassword)) {
            $errors[] = "Password must contain at least one special character.";
        }
    }

    // Validate OTP 
    if (empty($errors)) {
        $checkOtp = $pdo->prepare("SELECT Password FROM Customer WHERE Email = :email AND OTP = :otp");
        $checkOtp->execute([':email' => $email, ':otp' => $otp]);

        if ($checkOtp->rowCount() == 0) {
            $errors[] = "Invalid or expired OTP.";
        } else {
            $oldPassword = $checkOtp->fetchColumn(); // Fetch only the old password

            // Check if the new password equals the old password
            if ($newPassword === $oldPassword) {
                $errors[] = "The new password cannot be the same as the old password.";
            } else {
                // If OTP is valid and new password != old password, update the password
                $updatePassword = $pdo->prepare("UPDATE Customer SET Password = :password, OTP = NULL, OTP_Expiry = NULL WHERE Email = :email");
                $updatePassword->execute([
                    ':password' => $newPassword,
                    ':email' => $email
                ]);

                // Clear session variables after a successful password change
                unset($_SESSION['CustomerID']);
                unset($_SESSION['Username']);
                unset($_SESSION['AdminID']);
                unset($_SESSION['AdminUsername']);
                unset($_SESSION['reset_email']);

                // Redirect to index.php and show verify pass form success message
                header("Location: ../index.php?verify_pass_success=true");
                exit;
            }
        }
    }

    // Handle errors by redirecting
    if (!empty($errors)) {
        $errorString = urlencode(implode(', ', $errors));
        header("Location: ../index.php?verify_pass_error=" . $errorString);
        exit;
    }
}
