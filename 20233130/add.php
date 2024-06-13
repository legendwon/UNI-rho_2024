<?php

include './dbconn.php';

// 관리자 여부 확인
if (!(isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin')) {
    die("Access denied.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ann_who = mysqli_real_escape_string($connect, $_POST['ann_who']);
    $ann_date = mysqli_real_escape_string($connect, $_POST['ann_date']);
    $importance = mysqli_real_escape_string($connect, $_POST['importance']);
    $content = mysqli_real_escape_string($connect, $_POST['content']);

    $sql = "INSERT INTO cement (ann_who, ann_date, importance, content) VALUES ('$ann_who', '$ann_date', '$importance', '$content')";

    if ($connect->query($sql) === TRUE) {
        echo "<script>alert('New announcement added successfully');</script>";
        header('Location: cement.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Announcement</title>
</head>
<body>
    <h2>Add New Announcement</h2>
    <form method="post" action="add.php">
        <label for="ann_who">Who:</label>
        <input type="text" id="ann_who" name="ann_who" required><br><br>
        
        <label for="ann_date">Date:</label>
        <input type="datetime-local" id="ann_date" name="ann_date" required><br><br>
        
        <label for="importance">Importance:</label>
        <select id="importance" name="importance" required>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select><br><br>
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required></textarea><br><br>
        
        <button type="submit">Add Announcement</button>
    </form>
</body>
</html>
