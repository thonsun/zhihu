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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Free Bootstrap Themes by Html5xCss3 dot com - Free Responsive Html5 Templates">
    <meta name="author" content="#">

    <title>问答社区|添加问题</title>

    <link rel="stylesheet" href="css/menu.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/_bootswatch.scss">
    <link rel="stylesheet" type="text/css" href="css/bootstrap/css/_variables.scss">
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="font-awesome-4.4.0/css/font-awesome.min.css" type="text/css">

    <link rel="stylesheet" href="css/lightbox.css">

    <!-- Core JavaScript Files -->


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
            </ul>
        </div>
    </div>
</nav>

<div id="page-content" class="sub-page">
    <div class="container">
        <div class="col-md-8 offset-2">
            <div class="card text-center">
                <div class="card-body">
                    <h2>写问题</h2>
                    <div class="border-top pt-3 container">
                        <form name="form" method="post" action="add_question.php">
                            <div class="form-group">
                                <strong>问题标题:</strong>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="header" class="form-control" placeholder="请输入问题题目">
                                </div>
                            </div>
                            <div class="form-group">
                                <strong>问题摘要:</strong>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="abstract" class="form-control"
                                              placeholder="请输入问题关键字">
                                </div>
                            </div>
                            </div>
                            <div class="form-group">
                                <strong>问题详情:</strong>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <textarea type="message" name="content" class="form-control" rows="5" placeholder="请输入问题详情" style="overflow-y:scroll;overflow-x:hidden"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <strong>问题类型</strong>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <select name="qtype" class="selectpicker show-menu-arrow form-control">
                                        <option value="1">科学</option>
                                        <option value="2">运动</option>
                                        <option value="3">音乐</option>
                                        <option value="4">社会</option>
                                        <option value="5">国际</option>
                                    </select>
                                </div>
                            </div>

                            <!-- 一个分页请求输出 -->
                            <div class="form-group">
                                <strong>邀请回答</strong>
                                <div class="row" style="margin-top: 10px">
                                    <?php
                                    $perNum=12;
                                    $page=isset($_GET['page'])?$_GET['page']:1;

                                    $sql = "select count(*) nums from users";
                                    $result=@execute_sql($link,'zhihu',$sql);
                                    $totalNums=mysqli_fetch_object($result)->nums;
                                    $totalPage=$totalNums/$perNum;
                                    $startCount=($page-1)*$perNum;

                                    $sql="select * from users order by answers limit $startCount,$perNum";
                                    $result=execute_sql($link,'zhihu',$sql);
                                    while($obj=mysqli_fetch_object($result)){
                                        $id=$obj->id;
                                        $username=$obj->username;
echo <<< EOT
<div class="col-4" style="margin-top: 5px ">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <input type="checkbox" name="invited_id[]" value="$id">$username
            </div>
        </div>
    </div>
</div>
EOT;
}
echo "</div>";
echo <<<EOT
<div class="col-md-12 col-sm-12 col-xs-12">
EOT;
                                    if ($page!=1){
                                        $p=$page-1;
                                        echo "<a href='submit_question.php?page=$p'>上一页</a>";
                                    }
                                    for ($i=1;$i<=$totalPage;$i++) {
                                        echo "<a href='submit_question.php?page=$i'>".$i."</a>";
                                    }
                                    if ($page<$totalPage){
                                        $p=$page+1;
                                        echo "<a href='submit_question.php?page=$p'>下一页</a>";
                                    }
echo <<<EOT
   </div>
</div>
EOT;
@mysqli_free_result($result);
@mysqli_close($link);
                                    ?>
                            <input class="btn btn-danger" type="submit" name="submitcontact" value="提交">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function getTheCheckBoxValue() {
        var test = $("input[name='invited_user']:checked");
        var checkBoxValue = "";
        test.each(function () {
                checkBoxValue1 += $(this).val() + ",";
            }
        )
        checkBoxValue = checkBoxValue.substring(0, checkBoxValue.length - 1);
        alert(checkBoxValue)
    }
</script>
<!-- Once the page is loaded, initialized the plugin. -->
<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="js/jquery.smartmenus.js"></script>

<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>

<script src="js/lightbox-plus-jquery.min.js"></script>
</body>
</html>