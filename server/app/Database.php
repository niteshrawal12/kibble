<?php

class Database{
	private $conn;
	private $server = "localhost";
	private $user = "root";
	private $password = "";
	private $dbname = "kibble";
	public function getConnection(){
		try{
			$this->conn = new PDO("mysql:host={$this->server};dbname={$this->dbname}",$this->user,$this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return $this->conn;
		}catch(Exception $e){
			die("Error While Connected to Db -> ".$e->getMessage());
		}
	}
}

?>