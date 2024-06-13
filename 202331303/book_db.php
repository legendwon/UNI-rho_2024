<?php
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

$query = "SELECT book_db.SEQ_NO, TITLE_NM, AUTHR_NM, PUBLISHER_NM, PRC_VALUE, IMAGE_URL, IFNULL(loan_list.loan_status, '반납') AS loan_status,
                 loan_list.loan_date, DATE_ADD(loan_list.loan_date, INTERVAL 12 DAY) AS return_date
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
        :root {
            --bg-color-light: #f4f4f4;
            --bg-color-dark: #333;
            --text-color-light: #000;
            --text-color-dark: #f4f4f4;
            --main-bg-color-light: #fff;
            --main-bg-color-dark: #222;
            --main-text-color-light: #000;
            --main-text-color-dark: #fff;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--bg-color-light);
            color: var(--text-color-light);
            margin: 0;
            padding: 0;
            transition: background-color 0.3s, color 0.3s;
        }

        header {
            background-color: #333;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: relative;
        }

        header h1 {
            margin: 0;
        }

        header .user-greeting {
            position: absolute;
            right: 10px;
            top: 10px;
            font-size: 14px;
        }

        nav {
            display: flex;
            justify-content: center;
            background-color: #444;
        }

        nav button {
            background-color: #444;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        nav button:hover {
            background-color: #555;
        }

        .theme-switcher {
            text-align: center;
            margin: 10px 0;
        }

        .text-flip-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-left: 10px;
            border-radius: 4px;
        }

        .text-flip-btn:hover {
            background-color: #0056b3;
        }

        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background-color: var(--main-bg-color-light);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s;
            color: var(--main-text-color-light);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #333;
            color: white;
        }

        img {
            max-width: 100px;
            max-height: 100px;
            vertical-align: middle;
        }

        .loan-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .loan-btn:hover {
            background-color: #45a049;
        }

        .action-btns {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .dark-theme {
            --bg-color: var(--bg-color-dark);
            --text-color: var(--text-color-dark);
            --main-bg-color: var(--main-bg-color-dark);
            --main-text-color: var(--main-text-color-dark);
            background-color: var(--bg-color);
            color: var(--text-color);
        }

        .dark-theme main {
            background-color: var(--main-bg-color);
            color: var(--main-text-color);
        }

        .flipped-text {
            transform: scaleX(-1);
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

        function switchTheme(theme) {
            if (theme === 'dark') {
                document.body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            }
        }

        function flipText() {
            const mainElement = document.querySelector('main');
            mainElement.classList.toggle('flipped-text');
        }

        window.onload = function() {
            const storedTheme = localStorage.getItem('theme');
            if (storedTheme === 'dark') {
                document.body.classList.add('dark-theme');
                document.querySelector('input[name="theme"][value="dark"]').checked = true;
            } else {
                document.querySelector('input[name="theme"][value="light"]').checked = true;
            }
        }
    </script>
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

        function switchTheme(theme) {
            if (theme === 'dark') {
                document.body.classList.add('dark-theme');
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark-theme');
                localStorage.setItem('theme', 'light');
            }
        }

        function flipText() {
            const mainElement = document.querySelector('main');
            mainElement.classList.toggle('flipped-text');
        }

        window.onload = function() {
            const storedTheme = localStorage.getItem('theme');
            if (storedTheme === 'dark') {
                document.body.classList.add('dark-theme');
                document.querySelector('input[name="theme"][value="dark"]').checked = true;
            } else {
                document.querySelector('input[name="theme"][value="light"]').checked = true;
            }
        }
    </script>
</head>
<body>
    <header>
        <h1>도서관</h1>
        <div class="user-greeting">
            <?php
            if (isset($_SESSION['user_id'])) {
                echo "안녕하세요, " . htmlspecialchars($_SESSION['user_id'], ENT_QUOTES, 'UTF-8') . " 님!";
            } else {
                echo "안녕하세요, 방문자님!";
            }
            ?>
        </div>
    </header>
    <nav>
        <button onclick="location.href='./logout.php'">로그아웃</button>
        <button onclick="location.href='./mybook_db.php'">내 도서 목록</button>
        <button onclick="location.href='./my_info.php'">내 계정 보기</button>
        <button onclick="location.href='./cement.php'">공지사항</button>
    </nav>
    <div class="theme-switcher">
        <label>
            <input type="radio" name="theme" value="light" onchange="switchTheme('light')"> Light Theme
        </label>
        <label>
            <input type="radio" name="theme" value="dark" onchange="switchTheme('dark')"> Dark Theme
        </label>
    </div>
    <main>
        <h2>Book Database</h2>
        <table>
            <thead>
                <tr>
                    <th>SEQ_NO</th>
                    <th>TITLE_NM</th>
                    <th>AUTHR_NM</th>
                    <th>PUBLISHER_NM</th>
                    <th>PRC_VALUE</th>
                    <th>IMAGE_URL</th>
                    <th>대출 가능 여부</th>
                    <th>대출 날짜</th>
                    <th>반납 날짜</th>
                    <th>대출</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $seq_no = $row["SEQ_NO"] !== null ? htmlspecialchars($row["SEQ_NO"], ENT_QUOTES, 'UTF-8') : "";
                        $title_nm = $row["TITLE_NM"] !== null ? htmlspecialchars($row["TITLE_NM"], ENT_QUOTES, 'UTF-8') : "";
                        $authr_nm = $row["AUTHR_NM"] !== null ? htmlspecialchars($row["AUTHR_NM"], ENT_QUOTES, 'UTF-8') : "";
                        $publisher_nm = $row["PUBLISHER_NM"] !== null ? htmlspecialchars($row["PUBLISHER_NM"], ENT_QUOTES, 'UTF-8') : "";
                        $prc_value = $row["PRC_VALUE"] !== null ? htmlspecialchars($row["PRC_VALUE"], ENT_QUOTES, 'UTF-8') : "";
                        $image_url = $row["IMAGE_URL"] !== null ? htmlspecialchars($row["IMAGE_URL"], ENT_QUOTES, 'UTF-8') : "";
                        $loan_date = $row["loan_date"] !== null ? htmlspecialchars($row["loan_date"], ENT_QUOTES, 'UTF-8') : "";
                        $return_date = $row["return_date"] !== null ? htmlspecialchars($row["return_date"], ENT_QUOTES, 'UTF-8') : "";
                        $loan_status = $row["loan_status"] !== null ? htmlspecialchars($row["loan_status"], ENT_QUOTES, 'UTF-8') : "";

                        echo "<tr>";
                        echo "<td>" . $seq_no . "</td>";
                        echo "<td>" . $title_nm . "</td>";
                        echo "<td>" . $authr_nm . "</td>";
                        echo "<td>" . $publisher_nm . "</td>";
                        echo "<td>" . $prc_value . "</td>";
                        echo "<td>";
                        if (!empty($image_url)) {
                            echo "<img src='" . $image_url . "' alt='Book Image'>";
                        } else {
                            echo "No Image";
                        }
                        echo "</td>";
                        echo "<td>" . $loan_status . "</td>";
                        echo "<td>" . $loan_date . "</td>";
                        echo "<td class='return-date'>" . $return_date . "</td>";
                        echo "<td>";
                        if ($loan_status === '반납') {
                            echo "<button class='loan-btn'
                            onclick=\"loanBook('" . $seq_no . "')\">대출</button>";
                        } else {
                            echo "대출 중";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No books available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <script>
        

    </script>
</body>
</html>