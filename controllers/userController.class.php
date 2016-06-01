<?php

class userController
{

	public function indexAction($args){

	}

	public function showAction($args)
	{
		if(User::isConnected() && !empty($args[0])){
			$user = User::findById($args[0]);
			if ($user->getId() != $args[0]) {
				header("location:" . WEBROOT);
			}
            $v = new view();
            $teams = TeamHasUser::findBy("idUser",$args[0],"int",false);
            $v->setView("user/show.tpl");
            $v->assign("user", $user);
            $v->assign("teams",$teams);	
		}else{
			header('Location:' . WEBROOT . 'user/login');
		}
	}

	 /**
     * Edit an user profile
     * @param $args
     */
    public function editAction($args)
    {
    	if(User::isConnected() && !empty($args[0])){
			$user = User::findById($args[0]);
            $v = new view();
			$formEdit = $user->getForm("edit");
			if ($user->getId() != $args[0]) {
				header("location:" . WEBROOT);
			}
			$editErrors = [];
			if(!empty($_POST)) {
				$validator = new Validator();
				$editErrors = $validator->check($formEdit["struct"], $_POST);
				if(count($editErrors) == 0) {
					$user->setEmail(trim($_POST["email"]));
					$user->setUsername(trim(strtolower($_POST["username"])));
					$user->setFirstName(trim(strtolower($_POST["first_name"])));
					$user->setLastName(trim(strtolower($_POST["last_name"])));
					$user->setPhoneNumber($_POST["phone_number"]);
					$user->save();
				}
			}
            $v->setView("user/edit.tpl");
            $v->assign("user", $user);
            $v->assign("formEdit", $formEdit);
            $v->assign("editErrors", $editErrors);
		}else{
			header('Location:'.WEBROOT.'user/login');
		}
    }

	/**
	*
	*/
	public function subscribeAction($args) {
		$view = new view();
		$user = new User();
		$formSubscribe = $user->getForm("subscription");
		$formLogin = $user->getForm("login");
		$subErrors = [];
		$logErrors = [];

		$validator = new Validator();
		if(!empty($_POST)) {
			if($_POST["form-type"] == "subscription") {
				$subErrors = $validator->check($formSubscribe["struct"], $_POST);
				if(count($subErrors) == 0) {
					$user->setEmail($_POST['email']);
					$user->setUsername($_POST['username']);
					$user->setIsActive(0);
					$user->setToken();
					$user->save();
					if($user->sendConfirmationEmail()) {
						$view->assign( "mailerMessage", "An email has just been sent to ".$user->getEmail() );
					} else {
						$view->assign( "mailerMessage", "Something went when trying to send email." );
					}
				}
			}
			else if ($_POST["form-type"] == "login") {
				if($user = User::findBy("email", $_POST["email"], "string")) {
					if($user->getEmail() == trim($_POST["email"]) && $user->getPassword() == trim($_POST["password"])) {
						$user->setToken();
						$user->save();
						$token = $user->getToken();
						$id = $user->getId();
						$_SESSION["user_id"] = $id;
						$_SESSION["user_token"] = $token;
						header("location: ".WEBROOT);
					}
					else {
						$view->assign("error_message", "Couldn't find you :(");	
					}
				}
			}
		}
		$view->setView("user/subscribe.tpl");
		$view->assign("formSubscribe", $formSubscribe);
		$view->assign("subErrors", $subErrors);
		$view->assign("formLogin", $formLogin);
		$view->assign("logErrors", $logErrors);
	}

	public function activateAction($args) {
		$view = new view();
		$user = User::FindBy('email',$args['email'],'string');
		$view->setView("user/activation.tpl");
		$view->assign("user_token", $args["token"]);
		$formActivation = $user->getForm("activation");
		$actErrors = [];
		$validator = new Validator();
		$_SESSION['emailActivate']=$args["email"];
		$_SESSION['tokenActivate']=$args["token"];		
		if (isset($args["token"]) && !$user->findBy("token", $args["token"], "string")) {
			$view->assign("msg", "Not the page you're looking for");
		} 
		else if(isset($args["token"]) && $user->getToken() == $args["token"]) {
			if ($user->getIsActive() != 1) {
				$view->assign("formActivation", $formActivation);
				if(!empty($_POST)) {
					$actErrors = $validator->check($formActivation["struct"], $_POST);
					if(count($actErrors) == 0) {
						$user->setPassword($_POST["password"]);
						$user->setIsActive(1);
						$user->save();
						$view->assign("account_activated", "yeeha");
						$view->assign("msg", "Your account is now activated");
						session_destroy();
					}
				}
				$view->assign("actErrors",$actErrors);	
				} 
			else {
				$view->assign("msg", "Looks like your account had already been activated");
			}
		}
	}

	public function loginAction () {
		$view = new view();
		$view->setView("user/login.tpl");
		if(isset($_POST["login_form"])) {
			if($user = User::findBy("email", $_POST["email"], "string")) {
				if($user->getEmail() == trim($_POST["email"]) && (crypt(trim($_POST["password"]),$user->getPassword()) == $user->getPassword())){
					$user->setToken();
					print_r($user->getToken());
					$user->save();
					$token = $user->getToken();
					$id = $user->getId();
					$_SESSION["user_id"] = $id;
					$_SESSION["user_token"] = $token;
					header("location: ".WEBROOT);
				}
				else {
					$view->assign("error_message", "Couldn't find you :(");	
				}
			}
			else {
				$view->assign("error_message", "Couldn't find you :(");
			}
		}
	}

	/**
	* Logs out current user
	* @return void
	*/
	public function logoutAction () {
		session_destroy();
		header("location: ".WEBROOT."user/login");
	}

}