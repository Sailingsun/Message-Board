<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改留言</title>
</head>

<body>
<div style="width:100%">
<center>
	<h3>修改留言：</h3>
    <?php
	session_start ();
	if($_SESSION){
	$username = $_SESSION["username"]; 
	echo "欢迎您:";
	echo "${_SESSION["username"]}<br/>";
	}
	$link = @mysql_connect("localhost","root","") or die("数据库打开失败！");
	mysql_select_db("messagedb",$link)or die("数据库连接失败！");
	$sql = "select * from message where id={$_GET['id']};";
	$result = mysql_query($sql,$link);
//	echo $sql.$result;
	if($result && mysql_num_rows($result) > 0){
		$mess = mysql_fetch_assoc($result);
		}
		else{
			die("没有找到要修改的信息");
			}
		if($_SESSION){
			if($mess['username'] != $username){				
				echo "<script type='text/javascript'>"."window.alert('您不能修改此评论');"."window.location.href='index1.php'"."</script>";
			}
		}
		else{
				echo "<script type='text/javascript'>"."window.alert('您不能修改此评论');"."window.location.href='index.php'"."</script>";
		}
  ?>
<form action="action.php?action=update" method="post">
<input type="hidden" name="id" value="<?PHP echo $mess['id']; ?>" />
<table border="0">
<tr><th>留言标题：</th>
<td><input type="text" name="title" id="title" style="border-radius:4px;"  
value="<?PHP echo $mess['title'] ?>"/></td></tr>
<tr><th valign="top">留言内容：</th>
<td><textarea cols="60" rows="10" maxlength="500" name="content" id="content"
style="border-radius:6px;"><?PHP echo $mess['content'] ?></textarea></td></tr>
<tr><td colspan="2" align="center"><input type="submit" value="编辑" onclick="return ifLogin()"/> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button onclick="javascript:history.back()">返回</button></td></tr>
    </table>
    </form>
    </center>
    </div>
</body>
</html>