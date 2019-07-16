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
$user_id=$_COOKIE['id'];
$content=$_POST['content'];

$sql="select * from comments where questions_id=$question_id and users_id=$user_id";
$result=execute_sql($link,'zhihu',$sql);
if (@mysqli_num_rows($result)){
    @mysqli_free_result($result);
    @mysqli_close($link);
    header("location:question_detail.php?questionid=$question_id");
    exit();
}
else{
    $sql="insert into comments (users_id,questions_id,content) value ($user_id,$question_id,'$content')";
    $result=@execute_sql($link,'zhihu',$sql);

    @mysqli_free_result($result);
    @mysqli_close($link);
    echo "<script>alert('回复成功');window.location.href='question_detail.php?questionid=$question_id';</script>";
    }

?>