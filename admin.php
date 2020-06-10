<?php
require_once("server/app/app.php");

$session = $app->Validusersession();

if(!($session->status) || !($session->data->user_type == 'admin') ){
  unset($_SESSION["user_logged_in"]);
  unset($_SESSION["user_logged_in_id"]);
  unset($_SESSION["usersession"]);
  $app->redirect("login.php");
}

if( isset($app->post->web_series_upload_admin_form_button) ){
    $videoStream = new Videostream($app->getConnection());
    $videoStream->web_series_name = $app->post->web_series_name;
    $videoStream->web_series_genre = $app->post->web_series_genre;
    $videoStream->web_series_no_session_no_episodes = $app->post->web_series_no_session_no_episodes;
    $videoStream->web_series_episode_duration = $app->post->web_series_episode_duration;
    $videoStream->web_series_ratings = $app->post->web_series_ratings;
    
    $imageName = pathinfo($_FILES["web_series_image"]["name"]);
    $videoName = pathinfo($_FILES["web_series_video"]["name"]);
    
    $imageTmp = $_FILES["web_series_image"]["tmp_name"];
    $videoTmp = $_FILES["web_series_video"]["tmp_name"];

    $newImageName = $imageName["filename"]."_".time().".".$imageName["extension"];
    $newVideoName = $videoName["filename"]."_".time().".".$videoName["extension"];

    $uploadImagePath = "server/uploads/image/".$newImageName;
    $uploadVideoPath = "server/uploads/video/".$newVideoName;

    if( move_uploaded_file($imageTmp, $uploadImagePath) && move_uploaded_file($videoTmp, $uploadVideoPath) ){
        $videoStream->web_series_image = $uploadImagePath;
        $videoStream->web_series_video = $uploadVideoPath;
        $saveVideoStream = $videoStream->save();
        if($saveVideoStream->status){
             $_SESSION["usersession"] = '<div class="alert alert-success">
                <strong>Success !</strong> '.$saveVideoStream->message.'
                    </div>';
             $app->redirect("admin.php");
        }else{
            $_SESSION["usersession"] = '<div class="alert alert-danger">
                <strong>Error !</strong> Error While Uploading Image or Video Try Again!!!
                    </div>';
        $app->redirect("admin.php");
        }

    }else{
         $_SESSION["usersession"] = '<div class="alert alert-danger">
                <strong>Error !</strong> Error While Uploading Image or Video Try Again!!!
                    </div>';
        $app->redirect("admin.php");
    }

    die();
    exit();
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="assets/Bootstrap/css/bootstrap.min.css">
<title>Admin Form</title>
<style type="text/css">
    
    form .error{
         color:#FF0000;
    }
    
	.Signup-form {
		width: 400px;
    	margin: 50px auto;
	}
    .Signup-form form {
    	margin-bottom: 15px;
        background: #548063;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }
    .Signup-form h2 {
        margin: 0 0 15px;
    }
    .form-control, .btn {
        min-height: 38px;
        border-radius: 2px;
    }
    .btn {        
        font-size: 15px;
        font-weight: bold;
    }
	
	body
	{
		background-image: url("assets/img/back.jpg");
	}
</style>
</head>

<body>
<div class="Signup-form">
    <form action="javascript:return false;"  method="POST" enctype="multipart/form-data" name="web_series_upload_admin_form" id="web_series_upload_admin_form" autocomplete="off">
        <?= ($_SESSION["usersession"]) ? $_SESSION["usersession"] : ''; 
               unset($_SESSION["usersession"]);
                ?>
        <h2 class="text-center">Form</h2> 
		
		
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Name of web series" required="required" name="web_series_name" id="web_series_name">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Genre of web series" required="required" name="web_series_genre" id="web_series_genre">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Number of seasons and episodes in each season" required="required" name="web_series_no_session_no_episodes" id="web_series_no_session_no_episodes">
        </div>

          <div class="form-group">
            <input type="text" class="form-control" placeholder="Approximate duration of each episode" required="required" name="web_series_episode_duration" id="web_series_episode_duration">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Ratings" required="required" name="web_series_ratings" id="web_series_ratings">
        </div>

        <div class="form-group">
            <span>Choose Image of Web Series</span>
        <input type="file" name="web_series_image" id="web_series_image">
        </div>

		<div class="form-group">
			<span>Video of the web series</span>
		<input type="file" name="web_series_video" id="web_series_video">
		</div>

		<div class="form-group">
            <button type="submit" name="web_series_upload_admin_form_button" id="web_series_upload_admin_form_button" class="btn btn-primary btn-block"  style="margin-top:20px;">Uploads</button>
            <br/>
            <center><a href="kibble.php">Home Page</a></center>
        </div>
		</div>
        
               
    </form>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
    <script type="text/javascript">
        $("#web_series_upload_admin_form").validate({
            rules:{
               
                web_series_name:{
                    required:true
                },
                web_series_genre:{
                    required:true
                },
                web_series_no_session_no_episodes:{
                    required:true
                },
                web_series_episode_duration:{
                    required:true
                },
                web_series_ratings:{
                    required:true
                }

            },
            messages:{

                 web_series_name:{
                    required:"Required *"
                },
                web_series_genre:{
                    required:"Required *"
                },
                web_series_no_session_no_episodes:{
                    required:"Required *"
                },
                web_series_episode_duration:{
                    required:"Required *"
                },
                web_series_ratings:{
                    required:"Required *"
                }

            }
        })
        $("#web_series_upload_admin_form").submit(function(){
            let webSeriesForm = $(this);
            let imageLength = document.getElementById("web_series_image").files.length;
            let videoLength = document.getElementById("web_series_video").files.length;
            if(webSeriesForm.valid()){
                if(imageLength == 0){
                    alert("Select Image of Web Series");
                    return false;
                }
                if(videoLength == 0){
                    alert("Select Video of Web Series");
                    return false;
                }
                webSeriesForm.attr("action","<?= htmlspecialchars($_SERVER['PHP_SELF'])?>");
                document.web_series_upload_admin_form.submit();
            }else{
                return false;
            }
        });
    </script>
</body>
</html>                                		                            