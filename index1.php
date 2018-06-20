<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言</title>
</head>

<body>
<script type="text/javascript">	
	function empty_c(){    //判断内容是否为空
		var title = document.getElementById("title").value;
		var content = document.getElementById("content").value;
			if(title == "" || content == ""){
				alert("标题或内容不能为空");
				return false;
				}
		}

	function dodel(id){
		if(confirm("确认删除吗")){
			window.location="action.php?action=del&id="+id;
			}else{
				return false;
				}
		}
</script>

<div style="width:100%">
<center>
	<h3 align="left">我要留言：</h3>
    <?php
	session_start (); 
	echo "欢迎您:";
	echo "${_SESSION["username"]}；<br/>";
	echo "<a href='alter1_password.php'>修改密码</a> &nbsp;";
	echo "<a href='index.php'>退出登录</a>";
  ?>
<form action="action.php?action=add" method="post">
<table border="0">
<tr><th>留言标题：</th>
<td><input type="text" name="title" id="title" style="border-radius:4px;"  placeholder="请输入标题" /></td></tr>
<tr><th valign="top">留言内容：</th>
<td><textarea cols="60" rows="10" maxlength="500" name="content" id="content"
style="border-radius:6px;" placeholder="请输入留言……(最多输入500字符)"></textarea></td></tr>
<tr><td colspan="2" align="right"><input type="submit" value="提交留言" onclick="return empty_c()"/>    <input type="reset" value="重置"></td></tr>
    </table>
    </form>
    <hr>
    <h3 align="left">所有留言：</h3>
    <!----------搜索界面---------->	
	<form action="index1.php" method="get">
留言人：<input type="text" name="username" id="username" style="border-radius:4px;"  placeholder="search for user" value="<?PHP if(!empty($_GET['username'])) echo $_GET['username'] ?>" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
留言标题：<input type="text" name="title" id="title" style="border-radius:4px;"  placeholder="search for title" value="<?PHP if(!empty($_GET['title'])) echo $_GET['title'] ?>" />
<input type="submit" value="搜索" />    <input type="button" onclick="javascript:window.location='index1.php'" value="全部"><br/><br/><br/>
    </form>
 <!------------------------->   

<table border="1" width="60%" style="text-align:center; line-height:50px">
        <tr><th>留言人</th><th>留言标题</th><th width="30%">留言内容</th><th width="20%">留言时间</th><th>留言管理</th></tr>
<?PHP
	/*********************搜索相关*********************/
	$wherelist = array();
	$urllist = array();
	if(!empty($_GET['username'])){
			$wherelist[] = "username like '%{$_GET['username']}%'";
			$urllist[] = "username={$_GET['username']}";
		}
		if(!empty($_GET['title'])){
			$wherelist[] = "title like '%{$_GET['title']}%'";
			$urllist[] = "title={$_GET['title']}";
		}
		
		if(count($wherelist)>0){
				$where = " where ".implode(" and ",$wherelist);
				$url = "&".implode("&",$urllist);			
			}
	/************************************************/
	$link = @mysql_connect("localhost","root","") or die("数据库打开失败！");
	mysql_select_db("messagedb",$link)or die("数据库连接失败！");
	/*********************分页相关*********************/
	$page = isset($_GET['page'])?$_GET['page']:1;    //当前页
	$pageSize = 3;    //页大小
	$maxPages;		  //最大页数
	$maxRows;   	  //最大数据条数
	if(isset($where)){
	$sql = "select count(*) from message {$where};";
	}
	else{
		$sql = "select count(*) from message;";
		}
	$res = mysql_query($sql,$link);
	$maxRows = mysql_result($res,0,0);
	$maxPages = ceil($maxRows/$pageSize);
	if($page > $maxPages)  $page = $maxPages;
		if($page < 1)  $page = 1;
			if($maxPages < 1)  $maxPages = 1;
	$limit = " limit ".(($page-1)*$pageSize).",{$pageSize}";
	/************************************************/
	
	if(isset($where)){
	$result = mysql_query("select * from message $where order by addtime desc $limit;",$link);
	}
	else{
	$result = mysql_query("select * from message order by addtime desc $limit;",$link);		
		}
		/****************显示表格****************/
	while($row = mysql_fetch_assoc($result)){
		echo "<tr>";
		echo "<td>{$row['username']}</td>";
		echo "<td>{$row['title']}</td>";
		echo "<td>{$row['content']}</td>";
		echo "<td>".date('Y-m-d h:i:sa',$row['addtime']+7*3600)."</td>";
		echo "<td><a href='javascript:dodel({$row['id']})'>删除</a> 
		<a href='edit.php?id={$row['id']}'>修改</a></td>";
		echo "</tr>";
		}
		/**************************************/
		mysql_free_result($result);
		mysql_close($link);
?>
</table>
<?PHP
	echo "<br/><br/><br/><br/>";
	echo "当前第{$page}/{$maxPages}页 共{$maxPages}页";
	if(isset($url)){
	echo " <a href='index1.php?page=1{$url}'>首页</a> ";
	echo " <a href='index1.php?page=".($page-1)."{$url}'>上一页</a> ";
	echo " <a href='index1.php?page=".($page+1)."{$url}'>下一页</a> ";
	echo " <a href='index1.php?page={$maxPages}{$url}'>末页</a> ";
	}
	else{
		echo " <a href='index1.php?page=1'>首页</a> ";
		echo " <a href='index1.php?page=".($page-1)."'>上一页</a> ";
		echo " <a href='index1.php?page=".($page+1)."'>下一页</a> ";
		echo " <a href='index1.php?page={$maxPages}'>末页</a> ";
		}
?>
</center>
</div>
</body>
</html>