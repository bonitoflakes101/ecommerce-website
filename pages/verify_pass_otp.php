<?php
session_start();
require '../includes/db_config.php';

// para hindi ma-acces by url
if (!isset($_SESSION['reset_email'])) {
    header("Location: login.php");
    exit;
}

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $otp = trim($_POST['otp']);
    $newPassword = trim($_POST['new_password']);
    $email = $_SESSION['reset_email']; // get the email from the forgot_password file

    if (empty($otp) || empty($newPassword)) {
        $errors[] = "All fields are required.";
    }

    // password validation
    if (empty($errors)) {
        if (strlen($newPassword) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }
        if (!preg_match("/[A-Z]/", $newPassword)) {
            $errors[] = "Password must contain at least one uppercase letter.";
        }
        if (!preg_match("/[a-z]/", $newPassword)) {
            $errors[] = "Password must contain at least one lowercase letter.";
        }
        if (!preg_match("/[0-9]/", $newPassword)) {
            $errors[] = "Password must contain at least one number.";
        }
        if (!preg_match("/[\W_]/", $newPassword)) {
            $errors[] = "Password must contain at least one special character.";
        }
    }

    // validate otp 
    if (empty($errors)) {
        $checkOtp = $pdo->prepare("SELECT Password FROM Customer WHERE Email = :email AND OTP = :otp");
        $checkOtp->execute([':email' => $email, ':otp' => $otp]);


        if ($checkOtp->rowCount() == 0) {
            $errors[] = "Invalid or expired OTP.";
        } else {
            $oldPassword = $checkOtp->fetchColumn(); // fetch only the old password

            // check if the new password = old password
            if ($newPassword === $oldPassword) {
                $errors[] = "The new password cannot be the same as the old password.";
            } else {
                // if otp valid and new != old then update the password
                $updatePassword = $pdo->prepare("UPDATE Customer SET Password = :password, OTP = NULL, OTP_Expiry = NULL WHERE Email = :email");
                $updatePassword->execute([
                    ':password' => $newPassword,
                    ':email' => $email
                ]);

                // clear session variables after a successful password change
                unset($_SESSION['CustomerID']);
                unset($_SESSION['Username']);
                unset($_SESSION['AdminID']);
                unset($_SESSION['AdminUsername']);
                unset($_SESSION['reset_email']);

                $success = "Your password has been reset successfully.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>

<body>
    <h1>Verify OTP</h1>
    <form method="POST" action="">
        <input type="text" name="otp" placeholder="Enter OTP" required>
        <input type="password" name="new_password" placeholder="Enter new password" required>
        <button type="submit">Reset Password</button>
    </form>

    <?php if (!empty($errors)): ?>
        <div class="message"><?php echo implode('<br>', $errors); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <div class="navigation">
        <a href="../pages/login.php" class="button">Log-in</a>
    </div>
</body>

</html>