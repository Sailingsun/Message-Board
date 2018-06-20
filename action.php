<?PHP
	session_start ();
	if($_SESSION){ 
	$username = $_SESSION["username"];
	}
	$link = @mysql_connect("localhost","root","") or die("数据库打开失败！");
	mysql_select_db("messagedb",$link)or die("数据库连接失败！");
	
	switch($_GET["action"]){
		case "add":
			$title = $_POST['title'];
			$content = $_POST['content'];
			$addtime = time();
			$sql = "insert into message(id,username,title,content,addtime)
			values(null,'$username','$title','$content','$addtime');" or die("存入数据库失败");
			mysql_query($sql,$link);
			//echo $sql;
			header("Location:index1.php");
			break;

		case "del":
			$id = $_GET['id'];
			//$get_user = $_GET['username'];
			$sql = "select * from message where id={$_GET['id']};";
			$result = mysql_query($sql,$link);
			$res = mysql_fetch_assoc($result);
			$get_user = $res['username'];
			//echo $get_user;
			//echo $username;
		if($_SESSION){
			if($get_user == $username){
			$sql = "delete from message where id={$id}";
			mysql_query($sql,$link);
			header("Location:index1.php");
				}
			else{
				echo "<script type='text/javascript'>"."window.alert('您不能删除此评论');"."window.location.href='index1.php'"."</script>";
				}
			}
		else{
				echo "<script type='text/javascript'>"."window.alert('您不能删除此评论');"."window.location.href='index.php'"."</script>";
			}
			break;
		
				
		case "update":
			$id = $_POST['id'];
			$title = $_POST['title'];
			$content = $_POST['content'];
			$addtime = time();
			
			$sql = "update message set title='{$title}',content='{$content}',addtime='{$addtime}' where id='{$id}';";
			mysql_query($sql,$link);
			if($_SESSION){
				header("Location:index1.php");
			}else{
					header("Location:index.php");
				}
			break;
		
		}
		mysql_close($link);
?>
