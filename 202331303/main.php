<?php
include './dbconn.php';
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>도서 대여 서비스</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            color: #333333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333333;
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
            background-color: #444444;
        }
        nav button {
            background-color: #444444;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }
        nav button:hover {
            background-color: #555555;
        }
        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #333333;
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
        form {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        label {
            display: inline-block;
            width: 100px;
            text-align: right;
            color: #333333;
        }
        .box {
            width: 200px;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #dddddd;
            border-radius: 3px;
            background-color: #ffffff;
            color: #333333;
        }
        input[type="button"] {
            background-color: #333333;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="button"]:hover {
            background-color: #555555;
        }
        footer {
            background-color: #333333;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
            margin-top: auto; 
            position: fixed; 
            width: 100%; 
            bottom: 0; 
        }
        a {
            color: #000000;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        function checkform() {
            if (!document.review_table.custom_id.value) {
                alert('아이디가 입력되지 않았습니다.');
                document.review_table.custom_id.focus();
                return;
            } else if (!document.review_table.custom_pwd.value) {
                alert('비번이 입력되지 않았습니다.');
                document.review_table.custom_pwd.focus();
                return;
            } else if (!document.review_table.custom_name.value) {
                alert('이름이 입력되지 않았습니다.');
                document.review_table.custom_name.focus();
                return;
            } else if (!document.review_table.custom_age.value) {
                alert('나이가 입력되지 않았습니다.');
                document.review_table.custom_age.focus();
                return;
            }

            document.review_table.submit();
        }

        function goLoginform() {
            location.href = './login.php';
        }
    </script>
</head>
<body>
    <header>
        <h1>DB 입출력 테스트</h1>
        <div class="user-greeting">안녕하세요, 사용자님!</div>
    </header>
    <nav>
        <button onclick="location.href='book_db.php'">책 보기</button>
        <button onclick="location.href='cement.php'">공지사항</button>
    </nav>
    <main>
        <form action='./post.php' name='review_table' method='post'>
            <label>아이디: </label><input type="text" name="custom_id" class="box"/><br>
            <label>비번: </label><input type="password" name="custom_pwd" class="box"/><br>
            <label>이름: </label><input type="text" name="custom_name" class="box"/><br>
            <label>나이: </label><input type="text" name="custom_age" class="box"/><br>
            <input type="button" value="회원가입" onClick="checkform();"/>
            <input type="button" value="로그인" onClick="goLoginform();"/><br/>
        </form>
    </main>
    <footer>
        <p><a href="privacy.php">개인정보 보호 처리 방침</a></p>
        <p>&copy; 2024 CHO. All rights reserved.</p>
    </footer>
</body>
</html>
