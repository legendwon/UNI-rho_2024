<?php
session_start();
include './dbconn.php';

// 사용자가 대출 버튼을 누른 경우 로그인 상태를 확인하고 대출 처리
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['seq_no'])) {
    // 로그인되어 있는지 확인
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('로그인이 필요합니다.'); location.href='login.php';</script>";
        exit();
    }

    // 사용자가 대출 버튼을 누른 경우 대출 처리
    $seq_no = $_POST['seq_no'];
    $user_id = $_SESSION['user_id'];
    $loan_date = date('Y-m-d');
    $loan_status = '대출';

    $query = "INSERT INTO loan_list (seq_no, user_id, loan_date, loan_status) VALUES ('$seq_no', '$user_id', '$loan_date', '$loan_status')
              ON DUPLICATE KEY UPDATE loan_status='$loan_status', loan_date='$loan_date'";
    mysqli_query($connect, $query);
}

$query = "SELECT book_db.SEQ_NO, TITLE_NM, AUTHR_NM, PUBLISHER_NM, PRC_VALUE, IMAGE_URL, IFNULL(loan_list.loan_status, '반납') AS loan_status
          FROM book_db
          LEFT JOIN loan_list ON book_db.SEQ_NO = loan_list.seq_no AND loan_list.loan_status = '대출'";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Database</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #11a9c1;
            background-color: #11a9c1;
            color: white;
            margin: auto; 
        }
        th, td {
            border: 1px solid white;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: white;
            color: #11a9c1;
        }
        img {
            max-width: 100px;
            max-height: 100px;
            vertical-align: middle;
        }
    </style>
    <script>
        function loanBook(seq_no) {
            <?php if (!isset($_SESSION['user_id'])): ?>
            alert('로그인이 필요합니다.');
            return;
            <?php endif; ?>

            const form = document.createElement('form');
            form.method = 'post';
            form.action = 'book_db.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'seq_no';
            input.value = seq_no;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>
<body>
    <h2>Book Database</h2>
    <button onclick="location.href='./logout.php'">로그아웃</button>
    <button onclick="location.href='./mybook_db.php'">내 도서 목록</button>
    <table>
        <thead>
            <tr align="center">
                <th>SEQ_NO</th>
                <th>TITLE_NM</th>
                <th>AUTHR_NM</th>
                <th>PUBLISHER_NM</th>
                <th>PRC_VALUE</th>
                <th>IMAGE_URL</th>
                <th>대출 가능 여부</th>
                <th>대출</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["SEQ_NO"] . "</td>";
                    echo "<td>" . $row["TITLE_NM"] . "</td>";
                    echo "<td>" . $row["AUTHR_NM"] . "</td>";
                    echo "<td>" . $row["PUBLISHER_NM"] . "</td>";
                    echo "<td>" . $row["PRC_VALUE"] . "</td>";
                    echo "<td>";
                    if (!empty($row["IMAGE_URL"])) {
                        echo "<img src='" . $row["IMAGE_URL"] . "' alt='Book Image'>";
                    } else {
                        echo "No Image";
                    }
                    echo "</td>";
                    echo "<td>" . $row["loan_status"] . "</td>";
                    echo "<td>";
                    if ($row["loan_status"] === '반납') {
                        echo "<button onclick=\"loanBook(" . $row["SEQ_NO"] . ")\">대출</button>";
                    } else {
                        echo "대출 중";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>데이터 없음</td></tr>";
            }
            mysqli_close($connect);
            ?>
        </tbody>
    </table>
</body
