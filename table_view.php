<?php
require_once 'dbconfig.php';

// Query with JOINs, GROUP BY, aggregate functions and HAVING:
// total tickets sold and revenue per concert (paid purchases only)
$sql = "SELECT co.artist_name, co.venue, co.concert_date,
               COUNT(tp.purchase_id)          AS total_orders,
               SUM(tp.quantity)               AS tickets_sold,
               SUM(tp.total_amount)           AS revenue,
               ROUND(SUM(tp.quantity) / co.total_seats * 100, 4) AS percent_sold
        FROM concerts co
        INNER JOIN ticket_purchases tp ON co.concert_id = tp.concert_id
        WHERE tp.payment_status = 'Paid'
        GROUP BY co.concert_id, co.artist_name, co.venue, co.concert_date, co.total_seats
        HAVING SUM(tp.quantity) >= 1
        ORDER BY revenue DESC";

$rows = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Concert Sales Report</title>
    <style>
        table { border-collapse: collapse; width: 80%; margin: 20px auto; font-family: Arial; }
        th, td { border: 1px solid #999; padding: 8px; text-align: center; }
        th { background: #333; color: #fff; }
        tr:nth-child(even) { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Concert Sales Report (Paid Purchases)</h2>
    <table>
        <!-- Table header row -->
        <tr>
            <th>Artist</th><th>Venue</th><th>Date</th>
            <th>Orders</th><th>Tickets Sold</th><th>Revenue (PHP)</th><th>% Sold</th>
        </tr>

        <!-- Loop through each row of the result set and print it as a table row -->
        <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['artist_name']) ?></td>
            <td><?= htmlspecialchars($r['venue']) ?></td>
            <td><?= htmlspecialchars($r['concert_date']) ?></td>
            <td><?= $r['total_orders'] ?></td>
            <td><?= $r['tickets_sold'] ?></td>
            <td><?= number_format($r['revenue'], 2) ?></td>
            <td><?= $r['percent_sold'] ?>%</td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
