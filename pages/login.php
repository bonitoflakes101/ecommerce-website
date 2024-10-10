<?php
session_start();
require '../includes/db_config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password.";
    } else {
        // 1.) Check if admin
        $sql_admin = "SELECT AdminID, Username, Password FROM Admin WHERE Username = :username";
        $stmt_admin = $pdo->prepare($sql_admin);
        $stmt_admin->execute(['username' => $username]);
        $admin = $stmt_admin->fetch();

        // Check if admin credentials are valid
        if ($admin) {
            if ($password === $admin['Password']) {
                $_SESSION['AdminID'] = $admin['AdminID'];
                $_SESSION['AdminUsername'] = $admin['Username'];
                header("Location: admin.php"); // redirect to admin page
                exit;
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            // 2.) If admin not found, check for Customer credentials
            $sql_customer = "SELECT CustomerID, Username, Password, IsConfirmed FROM Customer WHERE Username = :username";
            $stmt_customer = $pdo->prepare($sql_customer);
            $stmt_customer->execute(['username' => $username]);
            $customer = $stmt_customer->fetch();

            // check if customer credentials are valid
            if ($customer) {
                if ($password === $customer['Password']) {
                    // check if the account is confirmed
                    if ($customer['IsConfirmed'] == 1) {
                        // Successful login for customer
                        $_SESSION['CustomerID'] = $customer['CustomerID'];
                        $_SESSION['Username'] = $customer['Username'];
                        $_SESSION['login_success'] = true;
                        header("Location: ../index.php");
                        exit;
                    } else {
                        $error = "Your account is not confirmed yet. Please check your email.";
                    }
                } else {
                    $error = "Invalid username or password.";
                }
            } else {
                $error = "Invalid username or password.";
            }
        }
    }
}

// if any error, redirect back to the index with error
if (!empty($error)) {
    header("Location: ../index.php?login_error=" . urlencode($error));
    exit;
}
