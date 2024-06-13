<?php

include './dbconn.php';

// 관리자 여부 확인
$isAdmin = isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin';

// 공지사항 조회 쿼리
$sql = "SELECT ann_num, ann_who, ann_date, importance, content FROM cement ORDER BY ann_date DESC";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .add-btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            text-align: center;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .add-btn:hover {
            background-color: #45a049;
        }
        .filter-form {
            text-align: center;
            margin: 20px 0;
        }
        .filter-form select {
            padding: 5px;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: center;
        }
        td {
            text-align: center;
        }
        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: #2196F3;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>공지사항</h1>

    <?php if ($isAdmin): ?>
        <a href="add.php" class="add-btn">Add New Announcement</a>
    <?php endif; ?>

    <div class="filter-form">
        <label for="importance-filter">Filter by Importance:</label>
        <select id="importance-filter" onchange="filterAnnouncements()">
            <option value="all">All</option>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select>
    </div>

    <?php
    if ($result->num_rows > 0) {
        echo "<table id='announcement-table'>
                <tr>
                    <th>Number</th>
                    <th>Who</th>
                    <th>Date</th>
                    <th>Importance</th>
                    <th>Content</th>";
        if ($isAdmin) {
            echo "<th>Actions</th>";
        }
        echo "</tr>";

        while($row = $result->fetch_assoc()) {
            $importanceColor = "";
            switch($row["importance"]) {
                case "low":
                    $importanceColor = "#90EE90"; // Light Green
                    break;
                case "medium":
                    $importanceColor = "#FFD700"; // Gold
                    break;
                case "high":
                    $importanceColor = "#FF6347"; // Tomato Red
                    break;
                default:
                    $importanceColor = "inherit";
            }
            echo "<tr class='announcement-row' data-importance='{$row["importance"]}'>
                    <td>{$row["ann_num"]}</td>
                    <td>{$row["ann_who"]}</td>
                    <td>{$row["ann_date"]}</td>
                    <td style='background-color: $importanceColor;'>{$row["importance"]}</td>
                    <td>{$row["content"]}</td>";
            if ($isAdmin) {
                echo "<td class='actions'>
                        <a href='edit.php?ann_num={$row["ann_num"]}'>Edit</a> |
                        <a href='delete.php?ann_num={$row["ann_num"]}' onclick=\"return confirm('Are you sure you want to delete this announcement?');\">Delete</a>
                      </td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No announcements found.</p>";
    }
    ?>

    <script>
    function filterAnnouncements() {
        var filter = document.getElementById("importance-filter").value;
        var rows = document.querySelectorAll(".announcement-row");

        rows.forEach(row => {
            if (filter === "all" || row.getAttribute("data-importance") === filter) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }
    </script>

</body>
</html>
