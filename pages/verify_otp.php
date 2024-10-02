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
        header("Location: ../index.php");
        exit();
    } else {
        $errors[] = "Invalid OTP or OTP has expired. Please try again.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <script>
        // function to show an alert on successful verification
        function showSuccessMessage() {
            alert("Your account has been successfully verified!");
        }
    </script>
</head>

<body>
    <h1>Verify OTP</h1>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if ($successMessage): ?>
        <p><?php echo htmlspecialchars($successMessage); ?></p> <!-- sanitize output -->
        <script>
            // call the function to show the success message
            showSuccessMessage();
        </script>
        <a href="login.php">Go to Login</a>
    <?php else: ?>
        <form action="verify_otp.php" method="POST">
            <label for="otp">Enter OTP:</label>
            <input type="text" name="otp" id="otp" required>
            <button type="submit">Verify</button>
        </form>
    <?php endif; ?>
</body>

</html>