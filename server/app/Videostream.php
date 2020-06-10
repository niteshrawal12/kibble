<?php

class Videostream{
	public $web_series_id;
	public $web_series_name;
	public $web_series_genre;
	public $web_series_no_session_no_episodes;
	public $web_series_episode_duration;
	public $web_series_ratings;
	public $web_series_image;
	public $web_series_video;

	private $conn;
	private $tableName;
	private $datetime;
	public function __construct($connection){
		$this->conn = $connection;
		$this->tableName = "video_tbl"; 
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
	public function Save(){
			try{
				$stmt = $this->conn->prepare("INSERT INTO $this->tableName (web_series_name,web_series_genre,web_series_no_session_no_episodes,
					web_series_episode_duration,web_series_ratings,web_series_image,web_series_video,web_series_modified,web_series_created) VALUES (:web_series_name, :web_series_genre, :web_series_no_session_no_episodes, :web_series_episode_duration, :web_series_ratings, :web_series_image, :web_series_video, :web_series_modified, :web_series_created )");
			$stmt->bindParam(":web_series_name",$this->web_series_name);
			$stmt->bindParam(":web_series_genre",$this->web_series_genre);
			$stmt->bindParam(":web_series_no_session_no_episodes",$this->web_series_no_session_no_episodes);
			$stmt->bindParam(":web_series_episode_duration",$this->web_series_episode_duration);
			$stmt->bindParam(":web_series_ratings",$this->web_series_ratings);
			$stmt->bindParam(":web_series_image",$this->web_series_image);
			$stmt->bindParam(":web_series_video",$this->web_series_video);
			$stmt->bindParam(":web_series_modified",$this->datetime);
			$stmt->bindParam(":web_series_created",$this->datetime);
			if($stmt->execute()){
				return $this->Response(true,"Vidoe Successfully Saved");
			}
		}catch(Exception $e){
			die("Exception Occured while User saving -> ".$e->getMessage());
		}

	}
	public function Get(){
			$stmt = $this->conn->prepare("SELECT * FROM {$this->tableName} WHERE web_series_id = :web_series_id");
			$stmt->bindParam(":web_series_id",$this->web_series_id);
			
			if($stmt->execute()){
				if($stmt->rowCount()){
					$videoDetails = $stmt->fetch(PDO::FETCH_OBJ);
					return $this->response(true,"Video Fetched Successfully",$videoDetails);
				}else{
					return $this->response(false,"Invalid Video Id");
				}
			}else{
				return $this->response(false,"Error Try Again!!!");
			}
	
	}
	public function Getall(){
			 $result = $this->conn->query("SELECT * FROM {$this->tableName}");
		     return $result->fetchAll(PDO::FETCH_OBJ);
	}
}