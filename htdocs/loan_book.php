<?php
session_start();
include './dbconn.php';

if (!isset($_SESSION['user_id'])) {
    echo "로그인이 필요합니다.";
    exit;
}

$seq_no = $_POST['seq_no'];
$user_id = $_SESSION['user_id'];
$loan_date = date('Y-m-d');
$loan_status = '대출';

// 대출 중복 확인
$query_check = "SELECT * FROM loan_list WHERE seq_no = $seq_no AND loan_status = '대출'";
$result_check = mysqli_query($connect, $query_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "이미 대출 중인 도서입니다.";
} else {
    $query = "INSERT INTO loan_list (seq_no, user_id, loan_date, loan_status) VALUES ($seq_no, '$user_id', '$loan_date', '$loan_status')";
    if (mysqli_query($connect, $query)) {
        echo "대출 성공";
    } else {
        echo "대출 실패: " . mysqli_error($connect);
    }
}

mysqli_close($connect);
?>

