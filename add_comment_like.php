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


$comment_id=isset($_GET['commentid'])?$_GET['commentid']:1;
$user_id=$_COOKIE['id'];
$sql="select questions_id from comments where id=$comment_id";
$result=execute_sql($link,'zhihu',$sql);
$question_id=mysqli_fetch_object($result)->questions_id;


$sql="update comments set love=love+1 where id=$comment_id";
$result=execute_sql($link,'zhihu',$sql);

@mysqli_free_result($result);
@mysqli_close($link);
header("location:question_detail.php?questionid=$question_id");
?>