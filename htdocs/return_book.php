<?php
session_start();
include './dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['seq_no'])) {
    $seq_no = $_POST['seq_no'];
    $user_id = $_SESSION['user_id'];

    // 도서를 반납하는 쿼리 실행
    $query = "DELETE FROM loan_list WHERE seq_no = '$seq_no' AND user_id = '$user_id'";
    if (mysqli_query($connect, $query)) {
        echo "도서가 반납되었습니다.";
    } else {
        echo "반납 실패";
    }
} else {
    echo "잘못된 요청입니다.";
}

mysqli_close($connect);
?>
