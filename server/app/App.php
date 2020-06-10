<?php
error_reporting(-1);
error_reporting(E_ALL ^ E_NOTICE);
ini_set("display_errors",-1);

session_start();
require_once "Database.php";
require_once "User.php";
require_once "Videostream.php";
require_once "Admin.php";

class App extends Database{
	public $post;
	private $mysql;
	private $user;
	private $admin;
	public $get;
	public function __construct(){
		$this->post = (object)$_POST;
		$this->get = (object)$_GET;
		$this->mysql = $this->getConnection();
		$this->user = new User($this->mysql);
		$this->admin = new Admin($this->mysql);
	}
	public function Redirect($location){
		header('Location: '.$location);
	}
	public function Response($status,$message,$data=""){
		return json_decode(json_encode(array('status'=>$status,'message'=>$message,'data'=>$data)));
	}
	public function Validusersession(){
		if( isset($_SESSION["user_logged_in"]) && $_SESSION["user_logged_in"] === true && isset($_SESSION["user_logged_in_id"]) ){	
			$this->user->user_id = $_SESSION["user_logged_in_id"];
			$userDetails = $this->user->Getuser();
			unset($userDetails->data->user_password);
			return $this->response(true,"User Details",$userDetails->data);
		}else{
			return $this->response(false,"Login Here");
		}
	}
	public function Validadminsession(){
		if( isset($_SESSION["admin_logged_in"]) && $_SESSION["admin_logged_in"] === true && 
			isset($_SESSION["admin_logged_in_id"]) ){
			$this->admin->admin_id = $_SESSION["admin_logged_in_id"];
			$adminDetails = $this->admin->Getadmin();
			unset($adminDetails->data->admin_password);
			return $this->response(true,"Admin Details",$adminDetails->data);
		}else{
			return $this->response(false,"Login Here");
		}
	}

}

$app = new App();