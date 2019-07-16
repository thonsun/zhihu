<?php
require_once("dbtools.inc.php");
$id=$_COOKIE['id'];
$correct_t=$_COOKIE['correct'];

$link = create_connection();
$sql="select * from users where id=$id";
$result=@execute_sql($link,'zhihu',$sql);

$user = @mysqli_fetch_object($result)->username;
$user = $user.'thonsun123';
if($correct_t!=md5($user)){
    @mysqli_free_result($result);
    @mysqli_close($link);
    header("location:login.php");
}

$question_id=isset($_GET['questionid'])?$_GET['questionid']:1;

$sql="update questions set love=love-1 where id=$question_id";
$result=execute_sql($link,'zhihu',$sql);
@mysqli_free_result($result);
@mysqli_close($link);
$referer = $_SERVER['HTTP_REFERER'];
//echo "<script>alert('$referer');</script>";

header("location:$referer");
?>