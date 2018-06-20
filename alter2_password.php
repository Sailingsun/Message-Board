<?php
  session_start (); 
  $username = $_REQUEST ["username"]; 
  $oldpassword = $_REQUEST ["oldpassword"]; 
  $newpassword = $_REQUEST ["newpassword"]; 
    
  $con=@mysql_connect("localhost","root","") or die('数据库连接失败'); 
  mysql_select_db("messagedb",$con);
  $dbusername = null; 
  $dbpassword = null; 
  $result=mysql_query("select * from login where username ='{$username}';");
  while ( $row = mysql_fetch_array ( $result ) ) { 
    $dbusername = $row ["username"]; 
    $dbpassword = $row ["password"]; 
  } 
  if (is_null ( $dbusername )) { 
    ?> 
  <script type="text/javascript"> 
    alert("用户名不存在"); 
    window.location.href="alter_password.html"; 
  </script>  
  <?php
  } 
  if ($oldpassword != $dbpassword) { 
    ?> 
  <script type="text/javascript"> 
    alert("密码错误"); 
    window.location.href="alter_password.html"; 
  </script> 
  <?php
  } 
  mysql_query ( "update login set password='{$newpassword}' where username='{$username}'" ) or die ( "存入数据库失败");
  mysql_close ($con); 
  ?> 
  
  
  <script type="text/javascript"> 
    alert("密码修改成功"); 
    window.location.href="index1.php"; 
  </script>