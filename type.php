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

$type=isset($_GET['type'])?$_GET['type']:1;
$perNum=5;
$page=isset($_GET['page'])?$_GET['page']:1;

$sql = "select count(*) nums from questions where qtypeid=$type";
$result=@execute_sql($link,'zhihu',$sql);
$totalNums=mysqli_fetch_object($result)->nums;
$totalPage=$totalNums/$perNum;
$startCount=($page-1)*$perNum;

?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>问答社区|首页</title>


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
                                                                          aria-hidden="true">提问</span></a>
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

                <form class="form-inline my-2 my-lg-0" action="search.php" method="post">
                    <input class="form-control mr-sm-2" type="text" name="keyword" placeholder="你想看什么？">
                    <button class="btn btn-danger my-2 my-sm-0" type="submit">搜索</button>
                </form>
            </ul>
        </div>
    </div>

</nav>

<div class="container" style="margin-top: 30px">
    <div class="row">
        <div class="col-lg-2">
            <div class="card text-white bg-success" style="min-width: 10rem;">
                <div class="card-header">问题类型</div>
                <div class="card-body">
                    <button type="button" class="btn btn-success"
                            onclick="window.location.href='type.php?type=1'">科学
                    </button>
                    <button type="button" class="btn btn-success"
                            onclick="window.location.href='type.php?type=2'">运动
                    </button>
                    <button type="button" class="btn btn-success"
                            onclick="window.location.href='type.php?type=3'">音乐
                    </button>
                    <button type="button" class="btn btn-success"
                            onclick="window.location.href='type.php?type=4'">社会
                    </button>
                    <button type="button" class="btn btn-success"
                            onclick="window.location.href='type.php?type=5'">国际
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-8" id="page-content">      
            <?php
                $sql="select * from questions where qtypeid=$type order by love limit $startCount,$perNum";
                $result=execute_sql($link,'zhihu',$sql);
                while($obj=mysqli_fetch_object($result)){
                    $addtime=$obj->addtime;
                    $title=$obj->qtitle;
                    $love=$obj->love;
                    $abtract=$obj->qcontent;
                    $id=$obj->id;
                    $abtract=substr($abtract,0,60);
echo <<< EOT
<div class="item">
    <div class="content-item">
        <h3 class="title-item"><a href="question_detail.php?questionid=$id">$title</a></h3>
        <div class="time">$addtime</div>
        <p class="info">$abtract</p>
    </div>
    <div class="bottom-item">
        <a href="add_attention.php?questionid=$id" class="btn btn-like"><i class="fa fa-heart-o"></i>关注</a>
        <a href="question_detail.php?questionid=$id" class="btn btn-comment"><i class="fa fa-comment-o"></i>回答</a>
        <a href="question_addlike.php?questionid=$id" class="btn btn-like"><i class="fa fa-thumbs-o-up"></i>顶$love</a>
        <a href="question_sublike.php?questionid=$id" class="btn btn-like"><i class="fa fa-thumbs-o-down"></i>踩</a>
    </div>
</div>

EOT;
    }
echo <<<EOT
<div class="item">
    <div class="content-item">
EOT;
    if ($page!=1){
        $p=$page-1;
        echo "<a href='index.php?page=$p'>上一页</a>";
    }
    for ($i=1;$i<=$totalPage;$i++) {
        echo "<a href='index.php?page=$i'>".$i."</a>";
    }
    if ($page<$totalPage){
        $p=$page+1;
        echo "<a href='index.php?page=$p'>下一页</a>";
    }
echo <<<EOT
    </div>
</div>
EOT;
@mysqli_free_result($result);
@mysqli_close($link);
?>

        </div>


        <div class="col-lg-2">
            <div class="card text-white bg-danger">
                <div class="card-header">做些什么</div>
                <div class="card-body">
                    <button type="button" class="btn btn-danger"
                            onclick="window.location.href='profile.php#myattention'"><span class=" fa fa-heart">&nbsp;我的关注</span>
                    </button>
                    <button class="btn btn-danger" onclick="window.location.href='submit_question.php'">写问题</button>
                    <button class="btn btn-danger" onclick="window.location.href='profile.php#invited_message'">写回答</button>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
<script src="https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js"></script>
<!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>

<script type="text/javascript" src="js/jquery-2.1.1.js"></script>

<!--jQuery Pinterest -->
<script type="text/javascript" src="js/jquery.pinto.js"></script>
<script type="text/javascript" src="js/main.js"></script>

<!-- Light Box -->
<script src="js/lightbox-plus-jquery.min.js"></script>

<!-- Menu -->
<script src="js/script.js"></script>

<script type="text/javascript">
    $('#container').pinto();
</script>

</body>
</html>