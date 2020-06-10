<?php

class Admin{
	public $admin_id;
	public $admin_name;
	public $admin_mobile;
	public $admin_email;
	public $admin_password;
	private $conn;
	private $tableName;
	private $datetime;
	public function __construct($connection){
		$this->conn = $connection;
		$this->tableName = "admin_tbl"; 
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
		$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE admin_email = :admin_email");
		$stmt->bindParam(":admin_email",$this->admin_email);
		$stmt->execute();
		return $stmt->rowCount();
	}
	public function Save(){
			if($this->Isuserexist()){
				return $this->response(false,"Admin Already Exist");
			}
			try{
				$stmt = $this->conn->prepare("INSERT INTO $this->tableName (admin_name,admin_email,admin_mobile,
					admin_password,admin_modified,admin_created) VALUES (:admin_name, :admin_email, :admin_mobile, :admin_password, :admin_modified, :admin_created)");
			$stmt->bindParam(":admin_name",$this->admin_name);
			$stmt->bindParam(":admin_email",$this->admin_email);
			$stmt->bindParam(":admin_mobile",$this->admin_mobile);
			$stmt->bindParam(":admin_password",$this->admin_password);
			$stmt->bindParam(":admin_modified",$this->datetime);
			$stmt->bindParam(":admin_created",$this->datetime);
			if($stmt->execute()){
				return $this->Response(true,"Admin Successfully Registered");
			}
		}catch(Exception $e){
			die("Exception Occured while User saving -> ".$e->getMessage());
		}

	}
	public function Get(){
			$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE admin_email = :admin_email AND admin_password = :admin_password");
			$stmt->bindParam(":admin_email",$this->admin_email);
			$stmt->bindParam(":admin_password",$this->admin_password);
			if($stmt->execute()){
				if($stmt->rowCount()){
					$adminDetails = $stmt->fetch(PDO::FETCH_OBJ);
					return $this->response(true,"User Fetched Successfully",$adminDetails->admin_id);
				}else{
					return $this->response(false,"Invalid Email or Password");
				}
			}else{
				return $this->response(false,"Error Try Again!!!");
			}
	
	}
	public function Getadmin(){
		$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE admin_id = :admin_id");
			$stmt->bindParam(":admin_id",$this->admin_id);
			if($stmt->execute()){
				if($stmt->rowCount()){
					$adminDetails = $stmt->fetch(PDO::FETCH_OBJ);
					return $this->response(true,"Admin Fetched Successfully",$adminDetails);
				}else{
					return $this->response(false,"Invalid Admin Id");
				}
			}else{
				return $this->response(false,"Error Try Again!!!");
			}
	}
}