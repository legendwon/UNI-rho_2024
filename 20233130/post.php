<?php

include './dbconn.php';

$userid = $_POST['custom_id'];
$userpwd = $_POST['custom_pwd'];
$username = $_POST['custom_name'];
$userage = $_POST['custom_age'];

// "admin"이라는 아이디로 계정 생성 방지
if ($userid === 'admin') {
    echo "
    <script>
    alert('The username \"admin\" is not allowed.');
    history.back();
    </script>
    ";
    exit();
}

// 아이디 중복 검사
$query_check = "SELECT * FROM info WHERE id = '$userid'";
$result_check = mysqli_query($connect, $query_check);

if (mysqli_num_rows($result_check) > 0) {
    // 이미 존재하는 아이디일 경우 처리
    echo "
    <script>
    alert('이미 존재하는 아이디입니다. 다른 아이디를 사용해주세요.');
    history.back();
    </script>
    ";
    exit();
}

// 아이디가 중복되지 않으면 새로운 사용자 정보를 데이터베이스에 삽입
$query_insert = "INSERT INTO info (id, pwd, name, age) VALUES ('$userid', '$userpwd', '$username', '$userage')";
$result_insert = mysqli_query($connect, $query_insert);

if ($result_insert) {
    echo "
    <script>
    location.href='./main.php';
    </script>
    ";
} else {
    echo "Error: " . mysqli_error($connect);
}

mysqli_close($connect);

?>
