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

$questions_id=$_GET['questionid'];

$sql ="update questions set look=look+1 where id=$questions_id";
$result=execute_sql($link,'zhihu',$sql);

$sql = "select * from questions where id=$questions_id";
$result = execute_sql($link,'zhihu',$sql);
$obj=@mysqli_fetch_object($result);

$title = $obj->qtitle;
$time=$obj->addtime;
$look=$obj->look;
$like=$obj->love;
$content=$obj->qcontent;
$img=$obj->img;
$auth_id=$obj->users_id;

$sql = "select count(*) nums from comments where questions_id=$questions_id";
$result=execute_sql($link,'zhihu',$sql);
$comment_nums=@mysqli_fetch_object($result)->nums;

$sql="select count(*) nums from attentions where questions_id=$questions_id";
$result=execute_sql($link,'zhihu',$sql);
$guanzhu=@mysqli_fetch_object($result)->nums;

$sql="select username from users where id=$auth_id";
$result=execute_sql($link,'zhihu',$sql);
$auth=@mysqli_fetch_object($result)->username;

$path='images/'.$img.'.jpg';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Free Bootstrap Themes by Html5xCss3 dot com - Free Responsive Html5 Templates">
    <meta name="author" content="#">

    <title>问答社区|问题详情</title>

    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/menu.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/_bootswatch.scss">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/_variables.scss">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css"  type="text/css">

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
                    <a class="nav-link active" href='index.php'><span class="fa fa-home" aria-hidden="true">首页</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href='submit_question.php'><span class="fa fa-pencil-square-o" aria-hidden="true">提问</span></a>
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

<div id="page-content" class="sub-page">
    <div class="container">
        <center>
        <article>
<?php
echo <<<EOT
<a class="example-image-link" href="$path" data-lightbox="example-set" data-title="Click the right half of the image to move forward."><img class="example-image" src="$path" alt=""/></a>
<div class="content-item">
    <h3 class="title-item"><a href="question_detail.php?questionid=$questions_id">$title</a></h3>
    <div class="time">$time</div>
    <ul class="list-inline">
        <li><a href="#"><i class="fa fa-eye"></i>$look</a></li>
        <li><a href="#"><i class="fa fa-comment"></i>$comment_nums</a></li>
        <li><a href="add_attention.php?questionid=$questions_id"><i class="fa fa-heart">$guanzhu</i></a></li>
        <li><a href="question_addlike.php?questionid=$questions_id""><i class="fa fa-thumbs-o-up"></i>$like</a></li>
    </ul>
    <p class="info">$content</p>
</div>


<div class="bottom-item">
    <a href="add_attention.php?questionid=$questions_id" class="btn btn-like"><i class="fa fa-heart-o"></i></a>
    <span class="user f-right">作者 $auth</span>
</div>
EOT;
?>

            <div id="contact_form">
            <?php
                echo "<form name='form1' id='ff' method='post' action='add_comment.php?questionid=$questions_id'>";
            ?>
                    <label>
                        <span>你的回答：</span>
                        <textarea name="content" id="message"></textarea>
                    </label>
                    <center><input class="sendButton" type="submit" name="submitcontact" value="提交"></center>
                </form>
            </div>
<div id="content_item">
<?php
    $sql="select * from comments where questions_id=$questions_id";
    $result=execute_sql($link,'zhihu',$sql);

    while($obj=mysqli_fetch_object($result)){
        $comment_id=$obj->id;
        $content=$obj->content;
        $user_id=$obj->users_id;
        $time=$obj->addtime;
        $love=$obj->love;

        $link2=create_connection();
        $sql2="select username from users where id=$user_id";
        $result2=execute_sql($link2,'zhihu',$sql2);
        $username=mysqli_fetch_object($result2)->username;

echo <<<EOT
<div class="item">
    <div class="content-item">
        <strong class="title-item">$username</strong>
        <div class="time">$time</div>
        <p class="info">$content</p>
    </div>
    <div class="bottom-item">
        <a href="add_comment_like.php?commentid=$comment_id" class="btn btn-like"><i class="fa fa-thumbs-o-up"></i> $love </a>
    </div>
</div>
EOT;

        mysqli_free_result($result2);
        mysqli_close($link2);
    }
    mysqli_free_result($result);
    mysqli_close($link);   
?>

            </div>

        </article>
        
        </center>
    </div>
</div>

<!-- Once the page is loaded, initialized the plugin. -->
<script type="text/javascript" src="js/jquery-2.1.1.js" ></script>
<script src="js/bootstrap.min.js"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>

<script src="js/lightbox-plus-jquery.min.js"></script>

<!-- Menu -->
<script src="js/script.js"></script>
</body>
</html>