<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include './dbconn.php';


// 세션에서 사용자 ID 가져오기
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = mysqli_real_escape_string($connect, $_SESSION['user_id']);

    $query = "SELECT * FROM info WHERE id = '$user_id'";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
}
?>

<script>
  function deldata() {
    location.href = './delete.php?id=<?php echo $user_id ?>';
  }
  function redata() {
    document.frm_content.submit();
  }
</script>

<center><h2>입력된 데이터</h2></center>
<form name="frm_content" method="post" action="update.php?uid=<?php echo $user_id; ?>">
  <table align="center" width="300" border="1" cellspacing="0" cellpadding="5">
    <tr align="center">
      <td bgcolor="#cccccc">아이디</td>
      <td>
        <input type="text" name="custid" value="<?php echo $row['id']; ?>" disabled>
        <input type="hidden" name="custid" value="<?php echo $row['id']; ?>">
      </td>
    </tr>
    <tr align="center">
      <td bgcolor="#cccccc">비밀번호</td>
      <td><input type="text" name="custpwd" value="<?php echo $row['pwd']; ?>"></td>
    </tr>
    <tr align="center">
      <td bgcolor="#cccccc">이름</td>
      <td><input type="text" name="custname" value="<?php echo $row['name']; ?>"></td>
    </tr>
    <tr align="center">
      <td bgcolor="#cccccc">나이</td>
      <td><input type="text" name="custage" value="<?php echo $row['age']; ?>"></td>
    </tr>
    <tr align="center">
      <td colspan="2" bgcolor="#cccccc">
          <input type="submit" value="수정">
          <input type="button" value="삭제" OnClick="deldata();">
      </td>
    </tr>
  </table>
</form>
