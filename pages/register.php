<?php
require '../includes/db_config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // check if all fields are filled
    if (empty($firstName) || empty($lastName) || empty($email) || empty($username) || empty($password)) {
        $errors[] = "All fields are required.";
    }

    // validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // Check for duplicate username
    if (empty($errors)) {
        $checkUsername = $pdo->prepare("SELECT * FROM Customer WHERE Username = :username");
        $checkUsername->execute([':username' => $username]);

        if ($checkUsername->rowCount() > 0) {
            $errors[] = "Username already taken. Please choose another.";
        }
    }

    // If no error, then insert into db
    if (empty($errors)) {
        // random id
        $newCustomerID = mt_rand(1000, 9999); // Adjust the range as needed

        // checks if may dupe
        $checkID = $pdo->prepare("SELECT * FROM Customer WHERE CustomerID = :customer_id");
        $checkID->execute([':customer_id' => $newCustomerID]);

        while ($checkID->rowCount() > 0) {
            $newCustomerID = mt_rand(1000, 9999); // regenerate if may dupe
            $checkID->execute([':customer_id' => $newCustomerID]);
        }

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
            echo "Registration successful! You can now log-in!";
        } else {
            $errors[] = "An error occurred during registration. Please try again.";
        }
    }
}
