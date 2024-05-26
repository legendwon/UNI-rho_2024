<?php
session_start();
include './dbconn.php';

// 사용자의 아이디 가져오기
$user_id = $_SESSION['user_id'];

// 사용자가 대출한 도서 목록 가져오기
$query = "SELECT loan_list.seq_no, TITLE_NM, AUTHR_NM, PUBLISHER_NM, PRC_VALUE, IMAGE_URL, loan_date, DATE_ADD(loan_date, INTERVAL 12 DAY) AS return_date
          FROM loan_list
          INNER JOIN book_db ON loan_list.seq_no = book_db.SEQ_NO
          WHERE loan_list.user_id = '$user_id'";
$result = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Books</title>
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
</head>
<body>
    <h2>My Books</h2>
    <button onclick="location.href='./logout.php'">로그아웃</button>
    <button onclick="location.href='./book_db.php'">책 보기</button>
    <table>
        <thead>
            <tr align="center">
                <th>SEQ_NO</th>
                <th>TITLE_NM</th>
                <th>AUTHR_NM</th>
                <th>PUBLISHER_NM</th>
                <th>PRC_VALUE</th>
                <th>IMAGE_URL</th>
                <th>대출 날짜</th>
                <th>반납 날짜</th>
                <th>반납</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["seq_no"] . "</td>";
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
                    echo "<td>" . $row["loan_date"] . "</td>";
                    echo "<td>" . $row["return_date"] . "</td>";
                    echo "<td><button onclick='returnBook(" . $row["seq_no"] . ")'>반납</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>대출한 도서가 없습니다.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    function returnBook(seq_no) {
        if (confirm('반납하시겠습니까?')) {
            // AJAX 요청 보내기
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'return_book.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // 요청이 성공적으로 처리된 경우
                        alert(xhr.responseText);
                        location.reload(); // 페이지 새로고침
                    } else {
                        // 요청에 문제가 있는 경우
                        alert('반납 실패');
                    }
                }
            };
            xhr.send('seq_no=' + seq_no);
        }
    }
</script>

</body>
</html>
