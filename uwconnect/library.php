<?php
	include ("server_conn.php");
	
	function drawLoginStatus()
	{
		echo "<div id='header' class='headerDiv'> <h4 align='center'> Welcome ". $_SESSION['connected']. " (Connected From -" .$_SERVER['REMOTE_ADDR'].") ". drawHref("Log Out", "login.php") ."</h4>
		<fb:login-button align='center'>Login with Facebook</fb:login-button></div>
		<div id='handle' style='display: none;' >". $_SESSION['connected']. "</div>";	
	}
	
	function drawButton($name, $value, $target)
	{
	 echo "<input type='submit' id='enterChat' class='btn btn-large btn-primary' name='".$name."' value ='".$value."' onClick='$target;' />";
	}
	
	function drawHref($name,$url)
	{
		return "<a href=".$url.">". $name ."</a>";
	}
	
	function pullNewMessage($handle)
	{
		$conn = connect();
		$query = "SELECT MsgId FROM users WHERE Handle='$handle'";
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		$id = $row["MsgId"];
		$query = "SELECT * FROM messages WHERE id > '$id'";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result))
		{
			$lastId = $row['id'];
			$query = "UPDATE users SET MsgId='$lastId' WHERE Handle='$handle'";
			mysql_query($query);
			echo  $row['Time']."\t".$row['Handle']."\t said:"."\t". $row['Message']."<br>";
		}
		disconnect($conn);
	}
	
	function pullFriendList()
	{
		$conn = connect();
		$query = "SELECT * FROM users WHERE IsConnected = 1";
		$result = mysql_query($query);
		while ($row = mysql_fetch_array($result))
		{
			 echo $row['Handle']."<br>";
		}
		disconnect($conn);
	}

	function drawLogout()
	{
		drawHref("Log Out", "login.php");
	}

	function sessionCheck()
	{
		if (!isset($_SESSION['connected']))
		{	
			return false;
		}
		return true;
	}

	function disconnect($conn)
	{
		if ($conn)
		{
			mysql_close($conn);
		}
	}

	function onLoginSuccess($handle)
	{
		if (!isset($_SESSION['connected']))
		{
			$_SESSION['connected'] = $handle;
		}
		echo $_SESSION['connected'];
		updateLoginStatus(1,$handle);
		header("Location: index.php");
	}

	function onLogOutSuccess()
	{
		updateLoginStatus(0,$_SESSION['connected']);
		session_destroy();
	}
	
	function submitNewMessage($handle, $message)
	{
		$query = "INSERT INTO messages (Handle,Message)	VALUES ('$handle','$message')";
		$conn = connect();
		if (!mysql_query($query, $conn))
		{
			die('Die :'.mysql_error());
		}
		disconnect($conn);
	}
	
	
	function signup($conn, $vals)	
	{
	if (!$conn)
	{
		echo "Connection Error " . mysql_error();
	}
	else
	{
		$handle = $vals['handle'] ;
		$fname = $vals['fname'];
		$lname = $vals['lname'];
		$password =crypt($_POST['passwd'],0) ;
		$email = $vals['email'];
		$conn = connect();
		$query = "INSERT INTO users (Handle,FName,LName,Password,EMail)
		VALUES ('$handle','$fname','$lname','$password','$email')";
		mysql_query($query);
		onLoginSuccess($handle);
		echo "Signup Successful" ;
		return true;
	}
}

	function updateLoginStatus($loginStatus,$handle)
	{
		$conn = connect();
		mysql_select_db("connect", $conn);
		$query = "UPDATE users SET IsConnected='$loginStatus' WHERE Handle='$handle'";
		mysql_query($query);
		disconnect();
	}
	
	function checkUsername($handle)
	{
		$conn = connect();
		$query = "SELECT * FROM users WHERE Handle='$handle'";
		$result = mysql_query($query, $conn);
		$row = mysql_fetch_array($result);
		if (!$row)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
	}
		
	function login($handle, $pass)
	{
		$conn = connect();
		$password = crypt($pass,0) ;
		$query = "SELECT * FROM users WHERE Handle='$handle'";
		$result = mysql_query($query, $conn);
		if (!$result)
		{
			die('Die :'.mysql_error());
			return false;
		}
		$row = mysql_fetch_array($result);
		if (!$row)
		{
			$_SESSION['error'] = "User does not exist, Please sign up!!";
		}
		else
		{	
			if ($row['Password']==$password)
			{
				onLoginSuccess($handle);
			}
			else
			{
				$_SESSION['error'] =  "Log in Failed!! Reason: Incorrect Password";
			}
		}
	}
?>
