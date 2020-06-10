<?php
require_once("server/app/App.php");


unset($_SESSION["user_logged_in"]);
unset($_SESSION["user_logged_in_id"]);
$app->redirect("login.php");

?>