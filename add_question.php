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

// Array ( [header] => 蜂窝肺 [abstract] => 蜂窝肺 [content] => 分为服务氛围 [qtype] => 1 [invited_id] => Array ( [0] => 25 [1] => 26 [2] => 27 [3] => 28 ) [submitcontact] => 提交 )

$qtitle=$_POST['header'];
$abstract=$_POST['abstract'];
$content=$_POST['content'];
$qtype=$_POST['qtype'];

$img = rand(1,30);

$sql = "insert into questions (qtitle,users_id,qkey,qtypeid,qcontent,img) value ('$qtitle',$id,'$abstract',$qtype,'$content',$img)";
$result=execute_sql($link,'zhihu',$sql);

$sql = "select * from questions order by id desc limit 0,1";
$result = execute_sql($link,'zhihu',$sql);
$question_id=@mysqli_fetch_object($result)->id;

foreach ($_POST['invited_id'] as $i){
        $sql = "insert into invite (users_id,questions_id,invite_id) value ($id,$question_id,$i)";
        $result = execute_sql($link,'zhihu',$sql);
    }

@mysqli_free_result($result);
@mysqli_close($link);
echo "<script>alert('添加成功');history.back();</script>";

?>