<?php
session_start();
require '../includes/db_config.php';

if (!isset($_SESSION['reset_email'])) {
    header("Location: ../index.php");
    exit;
}

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = trim($_POST['otp']);
    $newPassword = trim($_POST['new_password']);
    $email = $_SESSION['reset_email']; // from the forgot_password file
    $repeat_password = trim($_POST['repeat_password']);

    echo $newPassword;
    echo $repeat_password;
    // Check if passwords match
    if ($newPassword !== $repeat_password) {
        header("Location: ../index.php?verify_pass_error=" . urlencode("Passwords do not match."));
        exit;
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
