<?php
$explode = explode('/', $_SERVER['SCRIPT_NAME']);
$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
$lienbase = $protocol . $_SERVER['HTTP_HOST'] . str_replace(end($explode), '', $_SERVER['SCRIPT_NAME']);
define('WEBROOT', $lienbase);
define("DBHOST","localhost");
define("DBUSER","root");
date_default_timezone_set('Europe/Paris');

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    define("DBPWD","");
} else {
     define("DBPWD","root");
}

define("DBNAME","ninja_db");
define("SALT", "ABFffds32EOPDx32snklf443dsFDS464");

$errors_msg = [
	"email"=>"Your email isn't correct or allready exists",
	"username"=>"Username allready exists",
	"password"=>"Incorrect password",
	"confirm_password"=>"Different password",
	"teamName"=>"Incorrect team name or allready exists",
	"new_email" => "Your email isn't correct or allready exists",
	"new_username" => "Username allready exists",
  "username_doesnt_exists" => "This username doesn't exist",
	"emailOrUsername"=>"User not found, allready in team or allready invited",
	"avatar"=>"Invalid avatar",
	"sports"=>"ERROR 404 SPORT NOT FOUND",
	"new_teamName"=>"Incorrect team name or allready exists",
	"email_exist"=>"Couldn't find this email",
  "date_format"=>"Please stick to this date format => dd/mm/yyy",
  "time_format" => "Please stick to this time format => hh:mm",
  "useless"=>""

];
