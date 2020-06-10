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
            <div class="container"><a class="navbar-brand" href="#">Kibble Stream</a><button class="navbar-toggler" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
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
        <div class="carousel slide" data-ride="carousel" id="carousel-1">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active"><img class="w-100 d-block" src="assets/img/6.jpg" alt="Slide Image" width="600" height="400" style="width:100%;height:400px;"></div>
                <div class="carousel-item"><img class="w-100 d-block" src="assets/img/7.jpg" alt="Slide Image" style="width:100%;height:400px;"></div>
                <div class="carousel-item"><img class="w-100 d-block" src="assets/img/5.jpg" alt="Slide Image" style="height:400px;"></div>
            </div>
            <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button"
                    data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
            <ol class="carousel-indicators">
                <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-1" data-slide-to="1"></li>
                <li data-target="#carousel-1" data-slide-to="2"></li>
            </ol>
        </div>
    </div><br/>	

<div class="row">

<!-- 
<div class="col-md-3">
		<div class="card" style="width: 18rem; margin: 20px;">
  <img src="t1.jpg" class="card-img-top" alt="..." style="width:18rem; height:320px;">
  <div class="card-body">
    <h5 class="card-title">Sacred Games</h5>
      <a href="#" class="btn btn-primary">watch</a>
  </div>
</div>
</div> -->



<?php foreach ($videoStream->getall() as $key => $value) : ?>
  <div class="col-md-3">
    <div class="card" style="width: 18rem; margin: 20px;">
  <img src="<?= $value->web_series_image ?>" class="card-img-top" alt="..." style="width:18rem; height:320px;">
  <div class="card-body">
    <h5 class="card-title"><?= $value->web_series_name; ?></h5>
      <a href="watch-now.php?video_id=<?= $value->web_series_id; ?>" class="btn btn-primary">watch</a>
  </div>
</div>
</div>
<?php endforeach; ?>











</div>



	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>