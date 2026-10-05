<?php
// dbconfig.php - database connection file using PDO
// Include this file in every page that needs the database: require_once 'dbconfig.php';

$host    = "localhost";     // database server
$dbname  = "concert_db";    // database name (from concert_db.sql)
$user    = "root";          // default XAMPP username
$pass    = "";              // default XAMPP password is empty
$charset = "utf8mb4";       // character set

// Data Source Name (DSN) string that tells PDO which driver and database to use
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // return rows as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                    // use real prepared statements
];

try {
    // Create the PDO connection object
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Stop the script and show the error if connection fails
    die("Connection failed: " . $e->getMessage());
}
