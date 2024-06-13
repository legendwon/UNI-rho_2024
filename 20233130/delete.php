<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include './dbconn.php';

// 세션에서 사용자 ID 가져오기
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = mysqli_real_escape_string($connect, $_SESSION['user_id']);

    // 반납하지 않은 책이 있는지 확인
    $loan_query = "SELECT COUNT(*) AS loan_count FROM loan_list WHERE user_id = '$user_id'";
    $loan_result = mysqli_query($connect, $loan_query);
    $loan_row = mysqli_fetch_assoc($loan_result);

    if ($loan_row['loan_count'] > 0) {
        // 반납하지 않은 책이 있을 경우
        echo "<script>
            alert('반납하지 않은 책이 있습니다. 먼저 책을 반납해주세요.');
            location.href='./mybook_db.php';
            </script>";
    } else {
        // 반납하지 않은 책이 없을 경우 계정 삭제
        $delete_query = "DELETE FROM info WHERE id = '$user_id'";
        if (mysqli_query($connect, $delete_query)) {
            // 세션에서 사용자 ID 제거 (로그아웃 처리)
            unset($_SESSION['user_id']);
            session_destroy();

            echo "<script>
                alert('계정이 성공적으로 삭제되었습니다.');
                location.href='./main.php';
                </script>";
        } else {
            $error = mysqli_error($connect);
            echo "<script>
                alert('계정 삭제에 실패했습니다: " . addslashes($error) . "');
                location.href='./delete.php';
                </script>";
        }
    }
} else {
    echo "<script>
        alert('잘못된 요청입니다.');
        location.href='./delete.php';
        </script>";
}
?>
