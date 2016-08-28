<?php

//Pourquoi un modèle pour une table de liaison? Malheureusement avec le code actuel, si je peux afficher ou récupérer des infos
// de cette table je suis obligé de créer des instances différentes propre à ma table, du coups c'est plus simple de créer cette
// classe pour réutiliser les fonctions existantes.

class EventHasVote extends basesql
{
	protected $id;
	protected $table = "event_has_votes";
	protected $idEvent;
	protected $idUser;
  protected $upOrDown;

	protected $columns = [
		"id",
		"idEvent",
		"idUser",
    "upOrDown"
	];

	public function __construct(){
		parent::__construct();
	}

	public function getId() {
		return $this->id;
	}

	public function getIdEvent(){
		return $this->idEvent;
	}

	public function getIdUser() {
		return $this->idUser;
	}

  public function getUpOrDown(){
    return $this->upOrDown;
  }

	public function setId($id) {
		$this->id = $id;
	}

	public function setIdEvent($idEvent){
		$this->idEvent = $idEvent;
	}

	public function setIdUser($idUser){
		$this->idUser = $idUser;
	}

  public function setUpOrDown($upOrDown){
    $this->upOrDown = $upOrDown;
  }

  public static function getAllVotes($idEvent){
    $allVotes = EventHasVote::findBy("idEvent",$idEvent,"int");
    if(count($allVotes) == 0 ){
      return "0";
    }
    else{
      $votePour = count(EventHasVote::findBy(['idEvent','upOrDown'],[$idEvent,1],['int','int']));
      $voteContre = count(EventHasVote::findBy(['idEvent','upOrDown'],[$idEvent,0],['int','int']));
			return $votePour-$voteContre;
    }
  }

	public static function getMaxVoted(){
		$allVotes = EventHasVote::findAll();
		$idEvents = [];
		$votes = [];
		$result = [];
		foreach ($allVotes as $vote) {
			if(!in_array($vote->getIdEvent(),$idEvents) ){
				$idEvents[] = $vote->getIdEvent();
			}
		}

		foreach($idEvents as $idEvent){
			$vote = EventHasVote::findBy('idEvent',$idEvent,'int');
			if(count($vote) > 1){
				foreach($vote as $voting){
					$votes[] = ['idEvent'=>$idEvent,"vote"=>$voting->getUpOrDown()];
				}
			}else{
				$votes[] = ['idEvent'=>$idEvent,"vote"=>intval($vote[0]->getUpOrDown())];
			}
		}

		$result = array_reduce($votes,function($a,$b){
			isset($a[$b['idEvent']]) ? $a[$b['idEvent']]['vote'] += $b['vote'] : $a[$b['idEvent']] =$b;
			return $a;
		});

		$max = 0;
		foreach($result as $obj){
			if($obj['vote'] > $max){
				$max = $obj['idEvent'];
			}
		}
		return $max;
	}

}
