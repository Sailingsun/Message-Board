<?php 
    session_start(); 
    $username=$_REQUEST["username"]; 
    $password=$_REQUEST["password"];
    
	$con = @mysql_connect("localhost","root","")or die('数据库连接失败');
    mysql_select_db("messagedb",$con); 
    
	$dbusername=null; 
    $dbpassword=null;
    $result=mysql_query("select * from login where username ='{$username}';");
//    echo $result;
	while ($row=mysql_fetch_array($result)) { 
      $dbusername=$row["username"]; 
      $dbpassword=$row["password"]; 
    }
    if (is_null($dbusername)) {  
	?> 
  <script type="text/javascript"> 
    alert("用户名不存在"); 
    window.location.href="login.html"; 
  </script> 
  <?php 
    } 
    else { 
      if ($dbpassword!=$password){ 
  ?> 
  <script type="text/javascript"> 
    alert("密码错误"); 
    window.location.href="login.html"; 
  </script> 
  <?php 
      } 
      else {
	if(strtoupper($_POST["code"])!=strtoupper($_SESSION['code'])){
	?> 
	<script type="text/javascript"> 
    alert("验证码错误"); 
    window.location.href="login.html"; 
  </script> 
	<?PHP
    }  
        $_SESSION["username"]=$username; 
  ?> 
  <script type="text/javascript"> 
    window.location.href="index1.php";
  </script> 
  <?php 
      } 
    } 
  mysql_close($con);
  ?> 