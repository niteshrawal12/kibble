<?php
require_once("server/app/app.php");

if(isset($app->post->user_login_form_button)){
    $user = new User($app->getConnection());
    $user->user_email = $app->post->login_email;
    $user->user_password = $app->post->login_password;
    $validateUserLogin = $user->get();
    if($validateUserLogin->status){
        $_SESSION["user_logged_in"] = true;
        $_SESSION["user_logged_in_id"] = $validateUserLogin->data;
        $app->redirect("kibble.php");
    }else{
         $_SESSION["usersession"] = '<div class="alert alert-danger">
                <strong>Error !</strong> '.$validateUserLogin->message.'
                    </div>';
        $app->redirect("login.php");
    }
    die();

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
    <style type="text/css">
       form .error{
             color:#FF0000;
        }
    </style>
</head>

<body>
    <div class="login-dark">
        <form autocomplete="off" method="POST" action="javascript:return false;" name="user_login_form" id="user_login_form">
            <?= ($_SESSION["usersession"]) ? $_SESSION["usersession"] : ''; 
               unset($_SESSION["usersession"]);
                ?>
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <div class="form-group">
                <input class="form-control" type="email" name="login_email" id="login_email" placeholder="Email">
            </div>
            <div class="form-group"><input class="form-control" type="password" id="login_password" name="login_password" placeholder="Password">
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" type="submit" name="user_login_form_button">Log In</button>
            </div><a href="register.php" class="forgot">Register Here</a></form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
    <script type="text/javascript">
        const mailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        $.validator.addMethod("validateEmail",function(value,element,param){
            let user_email_id = $("#login_email").val();
            return user_email_id.match(mailRegex);
          },"Please enter a valid email address.");

            $("#user_login_form").validate({
                rules:{
                    login_email:{
                        required: true,
                        validateEmail: true
                    },
                    login_password:{
                        required:true
                    }
                },
                messages:{
                    login_email:{
                        required: "Required Email"
                    },
                    login_password:{
                        required: "Required Password"
                    }
                }
            });
            $("#user_login_form").submit(function(){
                //e.preventDefault();
                let userLoginForm = $(this);
                if(userLoginForm.valid()){
                    $(this).attr("action","<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>")
                    document.user_login_form.submit();
                }else{
                    return false;
                }
            });
    </script>
</body>

</html>