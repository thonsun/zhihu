<?php
session_start();

require_once("dbtools.inc.php");
header("Content-type:text/html;charset=utf-8");

$username=$_POST["name"];
$p=$_POST["password"];
$validate=$_POST["validate"];
$validate = strtolower($validate);

if($validate==$_SESSION['authnum_session']){
    $password=md5($p);
    $link=create_connection();
    $sql="SELECT * FROM users Where username='$username' AND passwd='$password'";
    $result=execute_sql($link,"zhihu",$sql);

    if(@mysqli_num_rows($result)==0)
    {
        @mysqli_free_result($result);
        mysqli_close($link);

        echo "<script type='text/javascript'>";
        echo "alert('账号密码错误，请重新输入');";
        echo "history.back();";
        echo "</script>";
    }

    else
    {
        $id=@mysqli_fetch_object($result)->id;
        $sql="select * from users where id=$id";
        $result=execute_sql($link,'zhihu',$sql);
        $r = $result;
        $user=@mysqli_fetch_object($result)->username;

        $username=$user."thonsun123";
        $correct=md5($username);

        mysqli_free_result($result);
        mysqli_close($link);

        setcookie("id",$id);
        setcookie("correct",$correct);

        header("location:index.php");
    }
}
else{
    echo "<script>alert('验证码错误');history.back();</script>";
}
?>
