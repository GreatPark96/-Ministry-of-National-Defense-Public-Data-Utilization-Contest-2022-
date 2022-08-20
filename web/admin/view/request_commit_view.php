<?php
    require_once 'admin/view/admin_top.php';
?>

<h3>관리자 페이지(필터요청 관리)</h3><hr/>
<div style="color:#6e6e6e;">
    <p>
        <lable>사용자가 요청한 필터를 추가 / 제거 할 수 있습니다.</lable><br>
    </p>
</div>
<table class="table table-striped" style="width:100%;">
    <thead>
            <tr>
                <th><label>선택</label></th>
                <th><label>순번</label></th>
                <th><label>군번</label></th>
                <th><label>이름</label></th>
                <th><label>교정어</label></th>
                <th><label>금칙어</label></th>
                <th><label>내용</label></th>     
            </tr>
        </thead>


<?php
    $db_con = mysqli_connect('192.168.0.13','root','xhdgkfk19!','contest','3307');
    
    mysqli_query($db_con, "set session character_set_connection=utf8;");
    mysqli_query($db_con, "set session character_set_results=utf8;");
    mysqli_query($db_con, "set session character_set_client=utf8;");

    $result = mysqli_query($db_con,'SELECT * FROM user_request');

    $data = array();

    for($i = 1; $row = mysqli_fetch_assoc($result); $i++){
        $data[$i] = $row; 
    }
    
    echo '<form method="POST">';
    for($i = 1; $i <= mysqli_num_rows($result); $i++)
    {   
        echo '<tr>';
        echo '<td><input type="checkbox" name="check[]" value="'.$data[$i]['id'].'"></td>';
        echo '<td>'.$i.'</td>';
        echo '<td>'.$data[$i]['military_id'].'</td>';
        echo '<td>'.$data[$i]['name'].'</td>';
        echo '<td>'.$data[$i]['word'].'</td>';
        echo '<td>'.$data[$i]['prohibit'].'</td>';
        echo '<td>'.$data[$i]['value'].'</td>';
        echo '</tr>';
    }
    
    echo '<tr><td colspan="7" style="text-align : right;">';
    echo '<input type="reset" class="btn btn-outline-primary" value="선택해제">&nbsp;&nbsp;';
    echo '<input type="submit" class="btn btn-outline-primary" value="항목추가" formaction="/admin/control/request_add_control.php">&nbsp;&nbsp;';     
    echo '<input type="submit" class="btn btn-outline-primary" value="항목제거" formaction="/admin/control/request_del_control.php">';     
    echo '</td></tr>'; 
    echo '</table>';    
    echo '</form>';

    mysqli_close($db_con);

    require_once 'lib/bottom.php';
?>


