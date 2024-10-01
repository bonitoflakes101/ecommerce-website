<?php
session_start();
require '../includes/db_config.php';

if (!isset($_SESSION['AdminID'])) {
    header("Location: login.php");
    exit;
}

$sql_orders = "SELECT o.OrderID, o.OrderDate, o.Status, c.FirstName, c.LastName 
               FROM `Order` o 
               JOIN Customer c ON o.CustomerID = c.CustomerID 
               ORDER BY o.OrderDate DESC";
$stmt_orders = $pdo->prepare($sql_orders);
$stmt_orders->execute();
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);

$message = "";

// 3.) Gets variables from js form
// 3.1) method, action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // 3.2) order id, action
    $orderID = $_POST['orderID'];
    $action = $_POST['action'];

    try {
        if ($action === 'confirm') {
            $sql_confirm = "UPDATE `Order` SET Status = 'Confirmed' WHERE OrderID = :orderID";
            $stmt_confirm = $pdo->prepare($sql_confirm);
            $stmt_confirm->execute(['orderID' => $orderID]);

            if ($stmt_confirm->rowCount() > 0) {
                $message = "Order #$orderID confirmed successfully.";
            } else {
                $message = "Failed to confirm Order #$orderID. It may have already been confirmed.";
            }
        } elseif ($action === 'reject') {
            $sql_reject = "UPDATE `Order` SET Status = 'Cancelled' WHERE OrderID = :orderID";
            $stmt_reject = $pdo->prepare($sql_reject);
            $stmt_reject->execute(['orderID' => $orderID]);

            if ($stmt_reject->rowCount() > 0) {
                $message = "Order #$orderID cancelled successfully.";
            } else {
                $message = "Failed to cancel Order #$orderID. It may have already been cancelled.";
            }
        }
    } catch (Exception $e) {
        $message = "An error occurred: " . $e->getMessage();
    }

    // refresh the page after the operation
    header("Location: admin.php?message=" . urlencode($message));
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/main.css">
    <script>
        // 2.) sets variables for sql if confirmed
        function confirmAction(action, orderID) {
            if (confirm("Are you sure you want to " + action + " this order?")) {
                // 2.1) sets POST and isset action
                const form = document.createElement("form");
                form.method = "POST";
                form.action = "admin.php";

                // 2.2) stores input of action(confirmed/cancelled) and orderid in form to be passed sa sql
                const inputOrderID = document.createElement("input");
                inputOrderID.type = "hidden";
                inputOrderID.name = "orderID";
                inputOrderID.value = orderID;

                const inputAction = document.createElement("input");
                inputAction.type = "hidden";
                inputAction.name = "action";
                inputAction.value = action;

                // append inputs to form
                form.appendChild(inputOrderID);
                form.appendChild(inputAction);

                // append form to body and submit
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Home</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Orders Management</h2>

        <!--  Displays message na nakuha from php-->
        <?php if (isset($_GET['message'])): ?>
            <p><?php echo htmlspecialchars($_GET['message']); ?></p>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                        <td><?php echo htmlspecialchars($order['FirstName'] . ' ' . $order['LastName']); ?></td>
                        <td><?php echo htmlspecialchars($order['OrderDate']); ?></td>
                        <td id="status-<?php echo $order['OrderID']; ?>"><?php echo htmlspecialchars($order['Status']); ?></td>
                        <td>
                            <button onclick="confirmAction('confirm', <?php echo $order['OrderID']; ?>)">Confirm</button> <!-- 1.) when clicked, triggers a function -->
                            <button onclick="confirmAction('reject', <?php echo $order['OrderID']; ?>)">Reject</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Your Company Name</p>
    </footer>
</body>

</html>