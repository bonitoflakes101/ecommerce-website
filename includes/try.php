@ -1,70 +1,116 @@
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