  <?php 
    session_start(); 
  ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改密码</title>
</head>

<body>      
	<center>
     <h1 style="margin-bottom:11%;">修改密码：</h1>
  <form action="alter2_password.php" method="post" onsubmit="return alter()" style="text-align:center; text-align-last:center;">

    <table border="0" width="20%" style="line-height:30px;" align="center">
    <tr><th width="45%">用户名：</th>
    <td width="55%"><input type="text" name="username" id ="username" /></td></tr> 
    <tr><th>旧密码：</th>
    <td><input type="password" name="oldpassword" id ="oldpassword"/></td></tr> 
    <tr><th>新密码：</th>
	<td><input type="password" name="newpassword" id="newpassword"/></td></tr> 
    <tr><th rowspan="2" valign="top">确认新密码：</th>
    <td height="36"><input type="password" name="assertpassword" id="assertpassword"/></td>
     <tr><td><input type="submit" value="修改密码" onclick="return alter()">&nbsp;&nbsp;
      <input type="button" value="返回" onclick="javascript:history.go(-1)" /></td></tr>
      </table>
  </form>
	</center>   
    <script type="text/javascript"> 
      document.getElementById("username").value="<?php echo "${_SESSION["username"]}";?>" 
    </script> 
  
  <script type="text/javascript"> 
    function alter() { 
        
      var username=document.getElementById("username").value; 
      var oldpassword=document.getElementById("oldpassword").value; 
      var newpassword=document.getElementById("newpassword").value; 
      var assertpassword=document.getElementById("assertpassword").value;
      if(newpassword.length < 6 || newpassword.length > 10) { 
        alert("新密码格式不对"); 
        return false; 
      } 
      if (assertpassword != newpassword||assertpassword==0) { 
        alert("两次密码输入不一致"); 
        return false; 
      } 
      return true; 
  
    } 
  </script>
  </body>
</html>
