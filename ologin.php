<?php
	
	$servername = "localhost:3306";
	$username = "root";
	$password = "";
	$dbname = "signup";
	$con=new mysqli($servername, $username, $password, $dbname);
	if($con->connect_error)
	{
		die("Connection failed : ".$con->connect_error);
	}
	
	
	$user=$_POST['email'];
	$pass=$_POST['password'];
	
	$passcheck = "";
	
	
	$q = "SELECT password FROM user WHERE username='$user'";
	$result = $con->query($q);
	if($result->num_rows > 0)
	{
		while($row = $result->fetch_assoc())
		{
			$passcheck = $row['password'];
		}
		if($pass == $passcheck)
		{
			header('Location: kibble.html');
		}
		else
		{
			$message = "Wrong password!";
			echo "<script type='text/javascript'>alert('$message');</script>";
		}
	}
	else
	{
		$message = "Username does not exist!";
			echo "<script type='text/javascript'>alert('$message');</script>";
	}
	
	$con->close();
?>