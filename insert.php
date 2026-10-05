<?php
require_once 'dbconfig.php';

// Data for the new purchase
$customerId = 3;
$concertId  = 2;
$ticketType = 'VIP';
$quantity   = 2;

try {
    // INSERT ... SELECT: the total amount is computed from the concert's ticket_price
    $sql = "INSERT INTO ticket_purchases
                (customer_id, concert_id, ticket_type, quantity, total_amount, payment_status)
            SELECT :cid, co.concert_id, :type, :qty, co.ticket_price * :qty2, 'Pending'
            FROM concerts co
            WHERE co.concert_id = :conid";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cid'   => $customerId,
        ':type'  => $ticketType,
        ':qty'   => $quantity,
        ':qty2'  => $quantity,
        ':conid' => $concertId,
    ]);

    // lastInsertId() gives the auto-increment ID of the new row
    echo "Record inserted! New purchase ID: " . $pdo->lastInsertId();
    echo "<br>Rows affected: " . $stmt->rowCount();
} catch (PDOException $e) {
    echo "Insert failed: " . $e->getMessage();
}
