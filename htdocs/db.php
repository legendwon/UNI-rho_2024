<?
 $db_host = "localhost";
 $db_user = "root";
 $db_passwd = "0000";
 $db_name = "mydb";

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
    echo 'Phew we have it!';
}

 $dbconn = new mysqli($db_host, $db_user, $db_passwd, $db_name);

 if ($dbconn->connect_errno) {
 die('Connection Error : '.$dbconn->connect_error);
 } else {
 echo "<center>DB 연결 완료!!</center>";
 }
 ?>
