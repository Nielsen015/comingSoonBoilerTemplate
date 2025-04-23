<?php
require 'config/database.php';
$conn = getDBConnection();

// Pagination logic
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Get total number of records
$total_result = $conn->query("SELECT COUNT(*) as total FROM subscribers");
$total_row = $total_result->fetch_assoc();
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $records_per_page);

// Get paginated records
$result = $conn->query("SELECT email, subscribed_at FROM subscribers ORDER BY subscribed_at DESC LIMIT $offset, $records_per_page");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Subscribers List</title>
    <link rel="icon" type="image/png" href="images/icons/logo.png"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        h1 {
            color: #007A3F;
            margin-bottom: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #007A3F;
            color: white;
            position: sticky;
            top: 0;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e6f7ed;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        
        .pagination a {
            color: #007A3F;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
            border-radius: 4px;
        }
        
        .pagination a.active {
            background-color: #007A3F;
            color: white;
            border: 1px solid #007A3F;
        }
        
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
        
        .mainweb a {
            font-size: 1rem;
            text-decoration: none;
            text-align: center;
            color: #007A3F;
            justify-content: center;
            display: block;
            padding: 10px;
            /* background-color: #f2f2f2; */
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        
        .records-info {
            margin-bottom: 15px;
            color: #666;
        }
        
        /* Media Queries */
        @media screen and (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            
            th, td {
                padding: 8px 10px;
            }
            
            .pagination a {
                padding: 6px 12px;
                font-size: 0.9rem;
            }
        }
        
        @media screen and (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            .pagination a {
                padding: 4px 8px;
                margin: 0 2px;
            }
        }
    </style>
</head>
<body>
    <h1>Subscribers (<?= $total_records ?>)</h1>
    
    <div class="records-info">
        Showing <?= ($offset + 1) ?> to <?= min($offset + $records_per_page, $total_records) ?> of <?= $total_records ?> entries
    </div>
    
    <table>
        <tr><th>Email</th><th>Subscribed At</th></tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['subscribed_at'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=1">&laquo; First</a>
            <a href="?page=<?= $page - 1 ?>">&lsaquo; Previous</a>
        <?php endif; ?>
        
        <?php 
        // Show page numbers
        $start_page = max(1, $page - 2);
        $end_page = min($total_pages, $page + 2);
        
        if ($start_page > 1) {
            echo '<a href="?page=1">1</a>';
            if ($start_page > 2) echo '<span>...</span>';
        }
        
        for ($i = $start_page; $i <= $end_page; $i++): ?>
            <a href="?page=<?= $i ?>" <?= $i == $page ? 'class="active"' : '' ?>><?= $i ?></a>
        <?php endfor;
        
        if ($end_page < $total_pages) {
            if ($end_page < $total_pages - 1) echo '<span>...</span>';
            echo '<a href="?page='.$total_pages.'">'.$total_pages.'</a>';
        }
        ?>
        
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?= $page + 1 ?>">Next &rsaquo;</a>
            <a href="?page=<?= $total_pages ?>">Last &raquo;</a>
        <?php endif; ?>
    </div>
    
    <p class="mainweb"><a href="home">Back to main page</a></p>
</body>
</html>