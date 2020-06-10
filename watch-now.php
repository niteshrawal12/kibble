<?php
require_once("server/app/app.php");

$session = $app->Validusersession();

if(!$session->status){
  unset($_SESSION["user_logged_in"]);
  unset($_SESSION["user_logged_in_id"]);
  unset($_SESSION["usersession"]);
  $app->redirect("login.php");
}
$videoStream = new Videostream($app->getConnection());
$videoStream->web_series_id = $app->get->video_id;
$videoData = $videoStream->get();
if(!($videoData->status)){
    $app->redirect("kibble.php");
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIBBLESTREAM</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cookie">
    <link rel="stylesheet" href="assets/css/Login-Form-Dark.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Button.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/Pretty-Footer.css">
    <link rel="stylesheet" href="assets/css/Registration-Form-with-Photo.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div>
        <nav class="navbar navbar-light navbar-expand-md navigation-clean">
            <div class="container"><a class="navbar-brand" href="kibble.php">Kibble Stream</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse"
                    id="navcol-1">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"><a class="nav-link" href="javascript:void(0)">Welcome <?= $session->data->user_name; ?></a></li>

                         
                        <?= ($session->data->user_type == 'admin') ? '<li class="nav-item" role="presentation"><a class="nav-link" href="admin.php">Add Video</a></li>' : '' ?>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="logout.php">Logout</a></li>
                        <!-- <li class="nav-item" role="presentation"><a class="nav-link active" href="#">Movies</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#">Web Series</a></li>
                        <li class="nav-item" role="presentation"><a class="nav-link" href="#">Sessions</a></li>
                        <li class="dropdown"><a class="dropdown-toggle nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">Genres&nbsp;</a> -->
                           
                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div>
   




   <div>

    <!-- <video width="320" height="240" controls>
  <source src="<?= $videoData->data->web_series_video; ?>" type="video/mp4">

Your browser does not support the video tag.
</video> -->

<video controls>
  <source src="<?= $videoData->data->web_series_video; ?>" type="video/mp4">
Your browser does not support the video tag.
</video>









   </div>


   <footer>
        <div class="row">
            <div class="col-sm-6 col-md-4 footer-navigation">
                <h3><a href="#">Kibble &nbsp;Stream</a></h3>
                <p class="company-name">kibble stream @2019</p>
            </div>
            <div class="col-sm-6 col-md-4 footer-contacts">
                <div><i class="fa fa-phone footer-contacts-icon"></i>
                    <p class="footer-center-info email text-left">+918349629637</p>
                </div>
                <div><i class="fa fa-envelope footer-contacts-icon"></i>
                    <p> <a href="#" target="_blank">18mcmc12@gmail.com</a></p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4 footer-about">
                <h4>About the company</h4>
                <p>Kibble Stream is an web series , movies streaming web site in which you can watch latest web series and their sessions. &nbsp;kibble stream is all about &nbsp;Entertainment stuff.</p>
                <div class="social-links social-icons"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a><a href="#"><i class="fa fa-github"></i></a></div>
            </div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        var $video  = $('video'),
        $window = $(window); 

        $(window).resize(function(){
            
            var height = $window.height();
            $video.css('height', height);
            
            var videoWidth = $video.width(),
                windowWidth = $window.width(),
            marginLeftAdjust =   (windowWidth - videoWidth) / 2;
            
            $video.css({
                'height': height, 
                'marginLeft' : marginLeftAdjust
            });
        }).resize();
    </script>
</body>

</html>