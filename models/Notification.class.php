<?php

class Notification extends basesql
{

	public $id;
	protected $table = "notifications";
	protected $id_user;
	protected $datetime;
	protected $type;
	protected $read = 0;
	protected $message = "";

	//Oui
	public function __construct(){
		parent::__construct();
	}

	//Guetteurs
	public function getId() {
		return $this->id;
	}
	public function getId_user() {
		return $this->id_user;
	}
	public function datetime() {
		return $this->datetime;
	}
	public function getType() {
		return $this->type;
	}
	public function getRead() {
		return $this->read;
	}
	public function getMessage() {
		return $this->message;
	}

	//Setteurs
	public function setId($id) {
		$this->id = $id;
	}
	public function setId_user($id_user) {
		$this->id_user = $id_user;
	}
	public function setDatetime($datetime) {
		$this->datetime = $datetime;
	}
	public function setType($type) {
		$this->type = $type;
	}
	public function setRead($read) {
		$this->read = $read;
	}
	public function setMessage($message) {
		$this->message = $message;
	}

}