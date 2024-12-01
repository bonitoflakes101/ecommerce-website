<?php
$host = 'localhost';
$port = '3307';                  // check your xampp if anong port gamit sa sql
$db = 'ecommerce_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


//mysqli_connect version - instead of PDO:
$db_hostname = $host;
$db_username = $user;
$db_password = $pass;
$db_database = $db;
$db_port = $port;
$db_conn = null;
try {
    $db_conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database, $db_port);
    date_default_timezone_set("Asia/Hong_Kong");
    echo '<script>console.log("DB connected at ' . date('h:i:s A \, l \, F  jS \,  Y') . '")</script>';
    
} catch (mysqli_sql_exception $e) {
    echo "DB not connected";
}
