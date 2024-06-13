<?php

// 에러 리포팅 설정
error_reporting(E_ALL);
ini_set("display_errors", 1);

include './dbconn.php';

$uid = $_GET['uid'];
$userid = $_POST['custid'];
$userpwd = $_POST['custpwd'];
$username = $_POST['custname'];
$userage = intval($_POST['custage']);  // 나이 필드를 정수로 변환

$query = "UPDATE info SET pwd = ?, name = ?, age = ? WHERE id = ?";
$stmt = mysqli_prepare($connect, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssis", $userpwd, $username, $userage, $uid);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        echo "
        <script>
        location.href='./book_db.php';
        </script>
        ";
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error: " . mysqli_error($connect);
}

mysqli_close($connect);

?>
