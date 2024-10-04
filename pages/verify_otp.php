<?php
session_start();
require '../includes/db_config.php';

// para hindi ma-access by url
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit;
}

$errors = [];
$successMessage = '';

// ADD ERROR HANDLING IF MALI OTP
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email']; // gets this from register
    $otp = trim($_POST['otp']);

    //check if tama otp
    $stmt = $pdo->prepare("SELECT * FROM Customer WHERE Email = :email AND OTP = :otp");
    $stmt->execute([':email' => $email, ':otp' => $otp]);

    if ($stmt->rowCount() == 1) {
        // update's verification status of customer + resets otp
        $updateSQL = "UPDATE Customer SET IsConfirmed = 1, OTP = NULL, OTP_Expiry = NULL WHERE Email = :email";
        $updateStmt = $pdo->prepare($updateSQL);
        $updateStmt->execute([':email' => $email]);

        // stores value to be used by login page
        $_SESSION['success_message'] = "Your account has been successfully verified!";
        unset($_SESSION['email']);
        // go to log-in
        header("Location: ../index.php?verify_email_success=true");

        exit();
    } else {
        $errors[] = "Invalid OTP or OTP has expired. Please try again.";
    }
    if (!empty($errors)) {
        $errorString = urlencode(implode(', ', $errors));
        header("Location: ../index.php?verify_email_error=" . $errorString);
        exit;
    }
}
