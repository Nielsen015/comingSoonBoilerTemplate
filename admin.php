<?php
require 'config/database.php';
$conn = getDBConnection();
$result = $conn->query("SELECT email, subscribed_at FROM subscribers ORDER BY subscribed_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Subscribers List</title>
    <link rel="icon" type="image/png" href="images/icons/logo.png"/>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        a { font-size: 14px; text-decoration: none; text-align: center;color: #007A3F; }
    </style>
</head>
<body>
    <h1>Subscribers (<?= $result->num_rows ?>)</h1>
    <table>
        <tr><th>Email</th><th>Subscribed At</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['subscribed_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="index.html">Back to main page</a></p>
</body>
</html>