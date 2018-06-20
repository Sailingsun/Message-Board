<?php 
   session_start(); 
   $username=$_REQUEST["username"]; 
   $password=$_REQUEST["password"]; 
  
   $con=@mysql_connect("localhost","root","") or die('数据库连接失败'); 
   mysql_select_db("messagedb",$con); 
   $dbusername=null; 
   $dbpassword=null; 
   $result=mysql_query("select * from login where username ='{$username}';"); 
    while ($row=mysql_fetch_array($result)) { 
      $dbusername=$row["username"]; 
      $dbpassword=$row["password"]; 
    } 
    if(!is_null($dbusername)){ 
  ?> 
  <script type="text/javascript"> 
    alert("用户已存在"); 
    window.location.href="register.html"; 
  </script>  
  <?php 
    } 
    mysql_query("insert into login (username,password) values('{$username}','{$password}')") or die("存入数据库失败") ; 
    mysql_close($con); 
  ?> 
  <script type="text/javascript"> 
    alert("注册成功"); 
    window.location.href="login.html"; 
  </script> 