<?php
   
    $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');
        
    mysqli_query($db_con, "set session character_set_connection=utf8;");
    mysqli_query($db_con, "set session character_set_results=utf8;");
    mysqli_query($db_con, "set session character_set_client=utf8;");

    if ($_POST['check'] == NULL)
    {
        ?>
        <script type="text/javascript">
            alert("제거항목을 체크해주세요.");
            history.go(-1);
        </script>
        <?php
    }else{

        $request_count = count($_POST['check']);

        for ($i = 0; $i < $request_count; $i++)
        {
            // 체크항목 user_request table 제거
            $del_sql = 'DELETE FROM user_request WHERE id= "'.$_POST['check'][$i].'"';
            mysqli_query($db_con,$del_sql);
        }
        
        ?>
        <script type="text/javascript">
            location.href = '/admin/view/request_commit_view.php';
            alert("<?php echo $request_count;?>개 항목이 제거되었습니다.");
        </script>
        <?php 
    }
    mysqli_close($db_con);
?>