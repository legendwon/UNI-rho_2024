<?php
session_start();
session_unset();  // 모든 세션 변수 지우기
session_destroy();  // 세션 종료
header('Location: login.php');  // 로그인 페이지로 리디렉션
exit();
?>
