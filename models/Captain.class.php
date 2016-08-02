<?php

//Pourquoi un modèle pour une table de liaison? Malheureusement avec le code actuel, si je peux afficher ou récupérer des infos
// de cette table je suis obligé de créer des instances différentes propre à ma table, du coups c'est plus simple de créer cette
// classe pour réutiliser les fonctions existantes.

class Captain extends basesql
{
	protected $id;
	protected $table = "captain";
	protected $idTeam;
	protected $idUser;
	protected $captain = 0;

	protected $columns = [
		"id",
		"idTeam",
		"idUser",
		"captain"
	];

	public function __construct(){
		parent::__construct();
	}

	public function getId() {
		return $this->id;
	}

	public function getIdTeam(){
		return $this->idTeam;
	}

	public function getIdUser() {
		return $this->idUser;
	}

	public function getCaptain() {
		return $this->captain;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function setIdTeam($idTeam){
		$this->idTeam = $idTeam;
	}

	public function setIdUser($idUser){
		$this->idUser = $idUser;
	}

	public function setCaptain($captain) {
		$this->captain = $captain;
	}

	public static function getTitre($captain){
		if($captain == 0){
			return "Newbie";
		}else if($captain == 1 ){
			return "Casual";
		}else if($captain == 2){
			return "Boss";
		}else if($captain == 3){
			return "Owner";
		}
	}
}
