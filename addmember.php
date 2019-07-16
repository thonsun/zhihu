<?php
session_start();
if($_POST){
    require_once("dbtools.inc.php");

    header("Content-type:text/html;charset=utf-8");

    $name=$_POST["name"];
    $password=$_POST["password"];
    $pwd=$_POST["password_again"];
    $email=$_POST["email"];
    $validate=$_POST["validate"];
    $validate = strtolower($validate);
    $sex=$_POST['sex'];

    if($validate==$_SESSION["authnum_session"]){
        if($password==$pwd){
            $p = md5($password);
            $link=create_connection();
            $sql="insert into users (username,email,passwd,sex) value ('{$name}','{$email}','{$p}','{$sex}')";
            $result=execute_sql($link,"zhihu",$sql);

            echo "<script>alert('注册成功');window.location.href='login.php';</script>";
            
            @mysqli_free_result($result);
            @mysqli_close($link);
        }
        else{
            echo "<script>alert('两次密码不一样');history.back();</script>";
            //<div class="alert alert-danger" role="alert">密码不一致</div>
        }
    }
    else{
        echo "<script>alert('验证码错误');history.back();</script>";
    }
}
?>