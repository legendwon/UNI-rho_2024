<?php
include './dbconn.php';

if (!(isset($_SESSION['user_id']) && $_SESSION['user_id'] === 'admin')) {
    die("Access denied.");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ann_num = mysqli_real_escape_string($connect, $_POST['ann_num']);
    $ann_who = mysqli_real_escape_string($connect, $_POST['ann_who']);
    $ann_date = mysqli_real_escape_string($connect, $_POST['ann_date']);
    $importance = mysqli_real_escape_string($connect, $_POST['importance']);
    $content = mysqli_real_escape_string($connect, $_POST['content']);

    $sql = "UPDATE cement SET ann_who='$ann_who', ann_date='$ann_date', importance='$importance', content='$content' WHERE ann_num=$ann_num";

    if ($connect->query($sql) === TRUE) {
        echo "Record updated successfully";
        header('Location: cement.php');
        exit();
    } else {
        echo "Error updating record: " . $connect->error;
    }
} else {
    if (isset($_GET['ann_num'])) {
        $ann_num = mysqli_real_escape_string($connect, $_GET['ann_num']);
        $sql = "SELECT * FROM cement WHERE ann_num = $ann_num";
        $result = $connect->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            die("Announcement not found.");
        }
    } else {
        die("Invalid request.");
    }
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Announcement</title>
</head>
<body>
    <h2>Edit Announcement</h2>
    <form method="post" action="edit.php">
        <input type="hidden" name="ann_num" value="<?php echo $row['ann_num']; ?>">
        <label for="ann_who">Who:</label>
        <input type="text" id="ann_who" name="ann_who" value="<?php echo $row['ann_who']; ?>" required><br><br>
        
        <label for="ann_date">Date:</label>
        <input type="datetime-local" id="ann_date" name="ann_date" value="<?php echo date('Y-m-d\TH:i', strtotime($row['ann_date'])); ?>" required><br><br>
        
        <label for="importance">Importance:</label>
        <select id="importance" name="importance" required>
            <option value="low" <?php if ($row['importance'] == 'low') echo 'selected'; ?>>Low</option>
            <option value="medium" <?php if ($row['importance'] == 'medium') echo 'selected'; ?>>Medium</option>
            <option value="high" <?php if ($row['importance'] == 'high') echo 'selected'; ?>>High</option>
        </select><br><br>
        
        <label for="content">Content:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" required><?php echo $row['content']; ?></textarea><br><br>
        
        <button type="submit">Update Announcement</button>
    </form>
</body>
</html>
