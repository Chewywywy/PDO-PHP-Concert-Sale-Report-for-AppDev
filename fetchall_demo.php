<?php
require_once 'dbconfig.php';   // bring in the $pdo connection

// Complex query: JOIN three tables to get every purchase with customer and concert details
$sql = "SELECT tp.purchase_id, c.full_name, co.artist_name, co.venue,
               tp.ticket_type, tp.quantity, tp.total_amount, tp.payment_status
        FROM ticket_purchases tp
        INNER JOIN customers c ON tp.customer_id = c.customer_id
        INNER JOIN concerts co ON tp.concert_id  = co.concert_id
        ORDER BY tp.total_amount DESC";

$stmt = $pdo->query($sql);      // run the query

// fetchAll() returns ALL rows at once as an array of arrays
$rows = $stmt->fetchAll();

echo "<h2>fetchAll() Demo</h2>";
echo "<pre>";                  // <pre> keeps print_r output readable
print_r($rows);                // display the whole result set
echo "</pre>";
