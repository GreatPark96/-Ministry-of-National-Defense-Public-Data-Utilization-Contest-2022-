<?php
   
    $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');
        
    mysqli_query($db_con, "set session character_set_connection=utf8;");
    mysqli_query($db_con, "set session character_set_results=utf8;");
    mysqli_query($db_con, "set session character_set_client=utf8;");

    if ($_POST['check'] == NULL)
    {
        ?>
        <script type="text/javascript">
            alert("추가항목을 체크해주세요.");
            history.go(-1);
        </script>
        <?php
    }else{

        $request_count = count($_POST['check']);

        for ($i = 0; $i < $request_count; $i++)
        {
            // 사용자가 체크한 항목 검색
            $result = mysqli_query($db_con, 'select * from user_request where id = "'.$_POST['check'][$i].'"');
            $result = mysqli_fetch_array($result);

            // 체크항목 request_filter table에 추가
            $ins_sql = "INSERT INTO request_filter(word,prohibit,value) VALUE('".$result['word']."', '".$result['prohibit']."', '".$result['value']."')";
            mysqli_query($db_con,$ins_sql);

            // 체크항목 user_request table 제거
            $del_sql = 'DELETE FROM user_request WHERE id= "'.$_POST['check'][$i].'"';
            mysqli_query($db_con,$del_sql);
        }
        // 필터 업데이트 정보 최신화(conf)
        
        $date_now = date('Ymd',time()); 
        $filter_sql = mysqli_query($db_con,'SELECT * FROM request_filter');
        $filter_num = mysqli_num_rows($filter_sql);

        $search = mysqli_query($db_con,'select * from conf where name = "request_filter_version"');

        if($search){
            
            $update_sql = 'UPDATE conf SET value = "'.$date_now.','.$filter_num.'" WHERE name = "request_filter_version"';
        }else{
            $update_sql = 'INSERT INTO conf(name,value) VALUES("request_filter_version","'.$date_now.','.$filter_num.'")'; 
        }

        mysqli_query($db_con,$update_sql);

        $file_name = "/project/filter_update/request/log/".date("Ymd").".txt";
        // 로그기록
        $file = fopen($file_name,"a+");
        if(!$file) die("Cannot open the file.");

        $msg = date("Y-m-d H:i:s")."\t".system( "whoami" )."\t"."+Data Insert : ".$request_count." Success.\n";
       
        fwrite($file, $msg);


        fclose($file);
    

        ?>
        <script type="text/javascript">
            location.href = '/admin/view/request_commit_view.php';
            alert("<?php echo $request_count;?>개 항목이 추가되었습니다.");
        </script>
        <?php 
    }
    mysqli_close($db_con);
?>