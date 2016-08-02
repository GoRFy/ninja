<?php

class Team extends basesql
{
	public $id;
	protected $table = "teams";
	public $teamName;
	public $dateCreated;
	public $sports = "";
	public $description = "";
	public $avatar = "";

	protected $columns = [
		"id",
		"teamName",
		"dateCreated",
		"sports",
		"description",
		"avatar",
	];

	public function __construct(){
		parent::__construct();
	}

	public function getId() {
		return $this->id;
	}

	public function getTeamName(){
		return $this->teamName;
	}

	public function getDateCreated() {
		return $this->dateCreated;
	}

	public function getSports(){
		return $this->sports;
	}

	public function getDescription() {
		return $this->description;
	}

	public function getAvatar(){
		return $this->avatar;
	}

	public function setId($id) {
		$this->idTeam = $id;
	}

	public function setTeamName($teamName){
		$this->teamName = htmlspecialchars($teamName);
	}

	public function setDateCreated($dateCreated) {
		$this->dateCreated = $dateCreated;
	}

	public function setSports($sports){
		$this->sports = $sports;
	}

	public function setDescription($description) {
		$this->description = htmlspecialchars($description);
	}

	public function setAvatar($avatar){
		$this->avatar = $avatar;
	}

	public static function imIn($idTeam){
		if(User::isConnected()){
			if(TeamHasUser::findBy(['idUser','idTeam'],[$_SESSION['user_id'],$idTeam],["int","int"])){
				return True;
			}else{
				return False;
			}
		}else{
			return False;
		}
	}

	public function getForm($formType){
		$form = [];
		if ($formType == "create") {
			$form = [
				"title" => "Créer ton équipe",
				"buttonTxt" => "Créer",
				"options" => ["method" => "POST", "action" => WEBROOT . "team/create"],
				"struct" => [
					"teamName"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Nom d'équipe", "required"=>1, "msgerror"=>"teamName" ],
					"description"=>[ "type"=>"textarea", "class"=>"form-control", "placeholder"=>"Description", "required"=>0, "msgerror"=>"description" ],
					"form-type" => ["type" => "hidden", "value" => "createTeam", "placeholder" => "", "required" => 0, "msgerror" => "hidden input", "class" => ""]
				]
			];
		}
		else if ($formType == "edit") {
			$form = [
				"title" => "Paramètres d'équipes",
				"buttonTxt" => "Confirmer",
				"options" => ["method" => "POST", "action" => WEBROOT . "team/edit/" . $this->id,"enctype"=>"multipart/form-data"],
				"struct"=>[
					"teamName"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Nom d'équipe", "required"=>1, "msgerror"=>"new_teamName", "value" => $this->getTeamName()],
					"description"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Description", "required"=>0, "msgerror"=>"newDescription", "value" => $this->getDescription()],
					"avatar"=>["type"=>"file","class"=>"form-control","placeholder"=>"Votre avatar","required"=>0,"msgerror"=>"avatar","value"=>"../../".$this->getAvatar()],]
			];
		}
		else if ($formType == "invite") {
			$form = [
				"title" => "Inviter un nouveau partenaire",
				"buttonTxt" => "Inviter",
				"options" => ["method" => "POST", "action" => WEBROOT . "team/invite/".$this->id],
				"struct"=>[
					"emailOrUsername"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Email ou pseudo à inviter", "required"=>1, "msgerror"=>"emailOrUsername"],
					"message"=>["type"=>"text","class"=>"form-control","placeholder"=>"Un message","required"=>0,"msgerror"=>"messageInvite"],]
					];
		}else if($formType = "askToJoin"){
			$form = [
				"title" => "Demander à rejoindre",
				"buttonTxt" => "Demander",
				"options" => ["method" => "POST","class"=>"askToJoinForm" ,"action" => WEBROOT . "team/askToJoin/".$this->id],
				"struct"=>[
					"message"=>["type"=>"text","class"=>"form-control","placeholder"=>"Votre message","required"=>0,"id"=>"message","msgerror"=>"messageInvite"],]
					];
		}

		return $form;
	}

};
