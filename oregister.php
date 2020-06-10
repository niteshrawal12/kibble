<?php
	$servername="localhost:3306";
	$username="root";
	$password="";
	$dbname="signup";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		die("Connection Failed : ".$conn->connect_error);
	}
	$em=$_POST['email'];
	$ps=$_POST['password'];

	$sql="insert into eregister values('$em','$ps')";
	$result=$conn->query($sql);

	if($result)
	{
		header('Location: kibble.html');
	}
	else{
		die("nnection failed");
	}
?>