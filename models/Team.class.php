<?php


class Team extends basesql
{
	protected $id;
	protected $table = "teams";
	protected $teamName;
	protected $dateCreated;
	protected $sports = <?php


class Team extends basesql
{
	protected $id;
	protected $table = "teams";
	protected $teamName;
	protected $dateCreated;
	protected $sports = "";
	protected $description = "";
	protected $img = "";

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

	public function getImg(){
		return $this->img;
	}

	public function setId($id) {
		$this->idTeam = $id;
	}

	public function setTeamName($teamName){
		$this->teamName = $teamName;
	}

	public function setDateCreated($dateCreated) {
		$this->dateCreated = $dateCreated;
	}

	public function setSports($sports){
		$this->sports = $sports;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function setImg($img){
		$this->img = $img;
	}

	public function getForm($formType){
		$form = [];
		if ($formType == "create") {
			$form = [
				"title" => "Create your own team",
				"options" => ["method" => "POST", "action" => WEBROOT . "team/create"],
				"struct" => [
					"teamName"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Team Name", "required"=>1, "msgerror"=>"teamName" ],
					"description"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Description", "required"=>0, "msgerror"=>"description" ],
					"form-type" => ["type" => "hidden", "value" => "createTeam", "placeholder" => "", "required" => 0, "msgerror" => "hidden input", "class" => ""]
				]
			];
		} 
		else if ($formType == "update") {

		}
		
		return $form;
	}

};
	protected $description = "";
	protected $img = "";

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

	public function getImg(){
		return $this->img;
	}

	public function setId($id) {
		$this->idTeam = $id;
	}

	public function setTeamName($teamName){
		$this->teamName = $teamName;
	}

	public function setDateCreated($dateCreated) {
		$this->dateCreated = $dateCreated;
	}

	public function setSports($sports){
		$this->sports = $sports;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function setImg($img){
		$this->img = $img;
	}

}
