<?php
require_once 'dbconfig.php';

$purchaseId = 5;   // ID of the record to delete

try {
    // Only delete CANCELLED purchases (extra safety condition)
    $sql  = "DELETE FROM ticket_purchases
             WHERE purchase_id = :id AND payment_status = 'Cancelled'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $purchaseId]);

    // rowCount() tells us whether something was really deleted
    if ($stmt->rowCount() > 0) {
        echo "Purchase #$purchaseId deleted successfully.";
    } else {
        echo "Nothing deleted. Record not found or not cancelled.";
    }
} catch (PDOException $e) {
    echo "Delete failed: " . $e->getMessage();
}
