<?php
require_once 'dbconfig.php';

$purchaseId = 3;        // record to update
$newQty     = 6;        // new ticket quantity
$newStatus  = 'Paid';   // new payment status

try {
    // UPDATE with JOIN: recompute total_amount using the concert's current ticket price
    $sql = "UPDATE ticket_purchases tp
            INNER JOIN concerts co ON tp.concert_id = co.concert_id
            SET tp.quantity       = :qty,
                tp.total_amount   = co.ticket_price * :qty2,
                tp.payment_status = :status
            WHERE tp.purchase_id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':qty'    => $newQty,
        ':qty2'   => $newQty,
        ':status' => $newStatus,
        ':id'     => $purchaseId,
    ]);

    echo "Rows updated: " . $stmt->rowCount();
} catch (PDOException $e) {
    echo "Update failed: " . $e->getMessage();
}
