<?php
    function create_connection()
    {
        $link=@mysqli_connect("localhost","db_username","db_password") or die("failed to connect datebase".mysqli_connect_error());
        mysqli_query($link,"SET NAMES utf8");
        return $link;
    }

    function execute_sql($link,$database,$sql)
    {
        mysqli_select_db($link,$database) or die("failed to open datebase".mysqli_error($link));
        $result=mysqli_query($link,$sql);
        return $result;
    }


    
    function test_input($data)
    {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
   
    function transform($data)
    {
        if (get_magic_quotes_gpc()) 
        {
        $data = stripslashes($data);
        }
        $data = mysql_real_escape_string($data);
        return $data;
    }
 
    function checkdata($pattern,$data)
    {
        if(preg_match($pattern,$data,$mathes))
        {
            return $mathes[0];
        }
        else{
            return NULL;
        }
    }


    function check_question($link,$username,$question)
    {
        $sql="select * from result where username='$username'";
        $result=@execute_sql($link,'ctf',$sql);
        $count=@mysqli_num_rows($result);
        for($i=0;$i<$count;$i++)
        {
            $p=@mysqli_fetch_object($result)->questionid;
            if($question==$p)
            {
                return false;
            }
        }
        return true;
    }
