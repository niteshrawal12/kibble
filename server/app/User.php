<?php

class User{
	public $user_id;
	public $user_name;
	public $user_mobile;
	public $user_email;
	public $user_password;
	private $conn;
	private $tableName;
	private $datetime;
	public function __construct($connection){
		$this->conn = $connection;
		$this->tableName = "user_tbl"; 
		$this->datetime = date('Y-m-d H:i:s');
	}
	public function generateSalt($length = 64){
		$i = 1;
		$string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0987123456";
		$salt = "";
		while($i <= $length){
			$salt .= $string{ mt_rand(0,strlen($string) -1 ) };
			$i++;
		}
		return $salt;
	}
	public function Response($status,$message,$data=""){
		return json_decode(json_encode(array('status'=>$status,'message'=>$message,'data'=>$data)));
	}
	public function Isuserexist(){
		$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE user_email = :user_email");
		$stmt->bindParam(":user_email",$this->user_email);
		$stmt->execute();
		return $stmt->rowCount();
	}
	public function Save(){
			if($this->Isuserexist()){
				return $this->response(false,"User Already Exist");
			}
			try{
				$stmt = $this->conn->prepare("INSERT INTO $this->tableName (user_name,user_email,user_mobile,
					user_password,user_modified,user_created) VALUES (:user_name, :user_email, :user_mobile, :user_password, :user_modified, :user_created)");
			$stmt->bindParam(":user_name",$this->user_name);
			$stmt->bindParam(":user_email",$this->user_email);
			$stmt->bindParam(":user_mobile",$this->user_mobile);
			$stmt->bindParam(":user_password",$this->user_password);
			$stmt->bindParam(":user_modified",$this->datetime);
			$stmt->bindParam(":user_created",$this->datetime);
			if($stmt->execute()){
				return $this->Response(true,"User Successfully Registered");
			}
		}catch(Exception $e){
			die("Exception Occured while User saving -> ".$e->getMessage());
		}

	}
	public function Get(){
			$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE user_email = :user_email AND user_password = :user_password");
			$stmt->bindParam(":user_email",$this->user_email);
			$stmt->bindParam(":user_password",$this->user_password);
			if($stmt->execute()){
				if($stmt->rowCount()){
					$userDetails = $stmt->fetch(PDO::FETCH_OBJ);
					return $this->response(true,"User Fetched Successfully",$userDetails->user_id);
				}else{
					return $this->response(false,"Invalid Email or Password");
				}
			}else{
				return $this->response(false,"Error Try Again!!!");
			}
	
	}
	public function Getuser($fetchAll = FALSE){
		if($fetchAll){
			 $result = $this->conn->query("SELECT * FROM {$this->tableName}");
		     return $result->fetchAll(PDO::FETCH_OBJ);
		}
		$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE user_id = :user_id");
			$stmt->bindParam(":user_id",$this->user_id);
			if($stmt->execute()){
				if($stmt->rowCount()){
					$userDetails = $stmt->fetch(PDO::FETCH_OBJ);
					return $this->response(true,"User Fetched Successfully",$userDetails);
				}else{
					return $this->response(false,"Invalid User Id");
				}
			}else{
				return $this->response(false,"Error Try Again!!!");
			}
	}
}