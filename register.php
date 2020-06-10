<?php
require_once("server/app/app.php");

if(isset($app->post->user_registration_form)){
    $user = new User($app->getConnection());
    $user->user_name = $app->post->user_name;
    $user->user_mobile = $app->post->user_mobile;
    $user->user_email = $app->post->user_email;
    $user->user_password = $app->post->user_password;
    $saveUser = $user->save();
    // print_r($saveUser);
    // die();
    if($saveUser->status){
        $_SESSION["usersession"] = '<div class="alert alert-success">
                <strong>Success !</strong> '.$saveUser->message.'
                    </div>';
        $app->redirect("register.php");
    }else{
        $_SESSION["usersession"] = '<div class="alert alert-danger">
                <strong>Error !</strong> '.$saveUser->message.'
                    </div>';
        $app->redirect("register.php");
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
    <div class="register-photo">
        <div class="form-container">
            <div class="image-holder"></div>

            <form method="POST"  action="javascript:return false;" autocomplete="off" id="user_registration_form_id" name="user_registration_form_id">
                <h2 class="text-center"><strong>Create</strong> an account.</h2>
                <?= ($_SESSION["usersession"]) ? $_SESSION["usersession"] : ''; 
               unset($_SESSION["usersession"]);
                ?>
                <div class="form-group">
                    <input class="form-control" type="text" name="user_name" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" name="user_mobile" id="user_mobile" placeholder="Enter Mobile No.">
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" name="user_email" id="user_email" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="user_password" id="user_password" placeholder="Enter Password">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="user_password_repeat" placeholder="Enter Password (repeat)">
                </div>
                <!-- <div class="form-group">
                    <div class="form-check"><label class="form-check-label"><input class="form-check-input" type="checkbox">I agree to the license terms.</label></div>
                </div> -->
                <div class="form-group">
                    <button class="btn btn-primary btn-block" name="user_registration_form" id="user_registration_form" value="user_registration_form_value" type="submit">Sign Up</button>
                </div>
                <a href="login.php" class="already">You already have an account? Login here.</a></form>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>
    <script type="text/javascript">

          const mailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
          const mobileReg = /^[6-9]\d{9}$/; 
          $.validator.addMethod("validateEmail",function(value,element,param){
            let user_email_id = $("#user_email").val();
            return user_email_id.match(mailRegex);
          },"Please enter a valid email address.");
          $.validator.addMethod("validateMobile",function(value,element,param){
            let user_mobile_no = $("#user_mobile").val();
            return user_mobile_no.match(mobileReg);
          },"Enter valid mobile no");

        $("#user_mobile").keypress(function(e){
            if(!(e.which > 47 && e.which < 58)){
                return false;
            }
        });
        $("#user_registration_form_id").validate({
            rules:{
                user_name:{
                    required:true
                },
                user_email:{
                    required:true,
                    validateEmail:true
                },
                user_mobile:{
                    required:true,
                    validateMobile:true
                },
                user_password:{
                    required:true
                },
                user_password_repeat:{
                    required:true,
                    equalTo:user_password
                }
            },
            messages:{
                user_name:{
                    required:"Required Username"
                },
                user_email:{
                    required:"Required Useremail"
                },
                user_mobile:{
                    required:"Required Usermobile"
                },
                user_password:{
                    required:"Required Userpassword"
                },
                user_password_repeat:{
                    required:"Required Confirm Userpassword",
                    equalTo:"Password Do not Matches"
                }
            }
        });
        $("#user_registration_form_id").submit(function(){
            
            let user_form = $(this);
            if(user_form.valid()){
                $(this).attr("action","<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>");
                document.user_registration_form_id.submit();
            }else{
                return false;
            }
            
        });
    </script>
</body>

</html>