<?php
require_once 'dbconfig.php';   // bring in the $pdo connection

$purchaseId = 2;               // the purchase we want to look up

// Prepared statement with a named placeholder (protects against SQL injection)
$sql = "SELECT tp.purchase_id, c.full_name, c.email, co.artist_name,
               co.concert_date, tp.ticket_type, tp.quantity, tp.total_amount
        FROM ticket_purchases tp
        INNER JOIN customers c ON tp.customer_id = c.customer_id
        INNER JOIN concerts co ON tp.concert_id  = co.concert_id
        WHERE tp.purchase_id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $purchaseId]);

// fetch() returns only ONE row (the next row in the result set)
$row = $stmt->fetch();

echo "<h2>fetch() Demo</h2>";
echo "<pre>";
print_r($row);                 // display the single row
echo "</pre>";
