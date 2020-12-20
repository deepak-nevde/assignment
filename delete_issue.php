<?php

include "db_config.php";

if(isset($_POST['issues'])){
    $count = count($_POST['issues']);
    for($i=0;$i<$count;$i++)
   {
    $issue_id = $_POST['issues'][$i];
    $update=("UPDATE issues SET is_active='0' WHERE id='$issue_id'");
    $res=mysqli_query($conn, $update);
   }
   
   if(isset($res))
   {
        return 'success';    
    }

}
?>