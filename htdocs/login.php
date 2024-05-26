<?php
session_start();
include './dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $pwd = $_POST['pwd'];

    $query = "SELECT * FROM info WHERE id = '$id' AND pwd = '$pwd'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['user_id'] = $id;
        echo "<script>alert('로그인 성공');</script>";
        header('Location: book_db.php'); // 로그인 성공 시 도서 목록 페이지로 이동
        exit();
    } else {
        echo "<script>alert('로그인 실패');</script>";
    }
    mysqli_close($connect);
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required>
        <br>
        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd" required>
        <br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
