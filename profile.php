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
$sql="select * from users where id=$id";
$result=execute_sql($link,'zhihu',$sql);
$obj=mysqli_fetch_object($result);
$username=$obj->username;
$email=$obj->email;
$questions=$obj->questions;
$answers=$obj->answers;
$sex=$obj->sex;

$num=rand(1,30);
$path="images/".$num.".jpg";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Free Bootstrap Themes by Html5xCss3 dot com - Free Responsive Html5 Templates">
    <meta name="author" content="#">

    <title>问答社区|个人信息</title>

    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link rel="stylesheet" href="css/menu.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/_bootswatch.scss">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/_variables.scss">
    <link rel="stylesheet" type="text/css" href="css/custom.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/lightbox.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background:#C83935;">
    <div class="center">
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="navbar-brand" href="index.php">TalkWith</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href='index.php'><span class="fa fa-home"
                                                                       aria-hidden="true">首页</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href='submit_question.php'><span class="fa fa-pencil-square-o"
                                                                          aria-hidden="true">写问题</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><span class="fa fa-bell-o" aria-hidden="true">通知</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php"><span class="fa fa-user" aria-hidden="true"></span>我的</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><span class="fa fa-power-off" aria-hidden="true">退出</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php
echo <<<EOT
<div class="card border-light  col-8 offset-2" style="margin-top: 30px;">
    <div class="card-body">
        <div class="center">
            <img src="$path" class="card-img-top rounded-circle small" style="height: 100px;width: 100px"/>
            <h1>$username</h1>
            <p class="text-muted"><strong>邮箱：</strong> $email </p>
        </div>
        <div class="border-top pt-3">
            <div class="row">
                <div class="col-lg-4">
                    <h6>回答数</h6>
                    <p>$answers</p>
                </div>
                <div class="col-lg-4">
                    <h6>提问数</h6>
                    <p>$questions</p>
                </div>
                <div class="col-lg-4">
                    <h6>性别</h6>
                    <p>$sex</p>
                </div>
            </div>
        </div>
    </div>
</div>
EOT;

?>
<a name="myattention"></a>
<div class="row" style="margin-top: 10px">
    <div class="col-md-8 offset-2 grid-margin">
        <div class="card border-light">
            <div class="card-body">

                <h2 class="card-title mb-0">我的关注</h2>
                <ul class="list-group" style="margin-top: 5px">

<?php
$sql="select * from attentions where users_id=$id";
$result=execute_sql($link,'zhihu',$sql);
while($obj=mysqli_fetch_object($result)){
    $question_id=$obj->questions_id;
    $sql2="select * from comments where questions_id=$question_id order by id desc limit 0,1";
    $result2=execute_sql($link,'zhihu',$sql2);

    while($obj2=mysqli_fetch_object($result2)){
        $user_id_comment=$obj2->users_id;
        $question_id_comment=$obj2->questions_id;
        $time_comment=$obj2->addtime;
        $sql3="select * from users where id=$user_id_comment";
        $result3=execute_sql($link,'zhihu',$sql3);
        $username_comment=mysqli_fetch_object($result3)->username;

        $sql3="select * from questions where id=$question_id_comment";
        $result3=execute_sql($link,'zhihu',$sql3);
        $title_comment=mysqli_fetch_object($result3)->qtitle;

        $p = $username_comment."&nbsp;回答了问题&nbsp;".$title_comment;
echo <<<EOT
<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-inline-block pt-3">
            <div>
                <div><a href="question_detail.php?questionid=$question_id">$p</a></div>
                <div class="d-flex align-items-center ml-2">
                    <i class="mdi mdi-clock text-muted"></i>
                    <small class=" ml-1 mb-0">Updated: $time_comment</small>
                </div>
            </div>
        </div>
    </div>
</li>
EOT;
    }


}

?>
                </ul>
            </div>
        </div>
    </div>
</div>
<a name=“myquestion></a>
<div class="row" style="margin-top: 10px">
    <div class="col-md-8 offset-2 grid-margin">
        <div class="card border-light">
            <div class="card-body">
                <h2 class="card-title mb-0">我的问题</h2>
                <ul class="list-group" style="margin-top: 5px">

<?php
$sql="select * from questions where users_id=$id";
$result=execute_sql($link,'zhihu',$sql);
while($obj=mysqli_fetch_object($result)){
    $title=$obj->qtitle;
    $time=$obj->addtime;
    $question_id_q=$obj->id;
echo <<<EOT
<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-inline-block pt-3">
            <div>
                <div><a href="question_detail.php?questionid=$question_id_q">$title</a></div>
                <div class="d-flex align-items-center ml-2">
                    <i class="mdi mdi-clock text-muted"></i>
                    <small class=" ml-1 mb-0">Updated:$time</small>
                </div>
            </div>
        </div>
    </div>
</li>
EOT;
}

?>
                </ul>
            </div>
        </div>
    </div>
</div>
<a name="invited_message"></a>
<div class="row" style="margin-top: 10px">
    <div class="col-md-8 offset-2 grid-margin">
        <div class="card border-light">
            <div class="card-body">
                <h2 class="card-title mb-0">邀请消息</h2>
                <ul class="list-group" style="margin-top: 5px">

<?php
$sql="select * from invite where invite_id=$id order by id desc";
$result=execute_sql($link,'zhihu',$sql);
while($obj=mysqli_fetch_object($result)){
    $question_id_invite=$obj->questions_id;
    $sql2="select * from questions where id=$question_id_invite";
    $result2=execute_sql($link,'zhihu',$sql2);
    $obj2=mysqli_fetch_object($result2);
    $title=$obj2->qtitle;
    $time=$obj2->addtime;
echo <<<EOT
<li class="list-group-item d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-inline-block pt-3">
            <div>
                <div><a href="question_detail.php?questionid=$question_id_invite">$title</a></div>
                <div class="d-flex align-items-center ml-2">
                    <i class="mdi mdi-clock text-muted"></i>
                    <small class=" ml-1 mb-0">Updated: $time</small>
                </div>
            </div>
        </div>
    </div>
</li>
EOT;
}



?>

                </ul>
            </div>
        </div>
    </div>
</div>



<!-- Once the page is loaded, initialized the plugin. -->
<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-2.1.1.js"></script>-->
<!--<script src="js/bootstrap.min.js"></script>-->

<!-- SmartMenus jQuery Bootstrap Addon -->
<!--<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>-->

<script src="js/lightbox-plus-jquery.min.js"></script>

<!-- Menu -->
<script src="js/script.js"></script>
</body>
</html>