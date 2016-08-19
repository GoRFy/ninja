<?php

class basesql extends PDO
{

	private $pdo;

	public function __construct()
	{
		$dsn = "mysql:host=".DBHOST.";dbname=".DBNAME;
		try{
			$this->pdo = new PDO($dsn,DBUSER,DBPWD);
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(Exception $e){
			die("Erreur SQL:".$e->getMessage());
		}
        $this->pdo->query("SET NAMES UTF8");

		//$this->table = get_called_class();
		$all_vars = get_object_vars($this);
		$class_vars = get_class_vars(get_class());
		//$this->columns = array_keys(array_diff_key($all_vars, $class_vars));

		// Unsetting "table" attribute
		if(($key = array_search("table", $this->columns)) !== false) {
		    unset($this->columns[$key]);
		}
	}

	public static function findAll($limit = false, $orderBy = false, $column = "*", $orderWay="ASC") {
		$instance = new static;
		if(is_array($column)){
			$sql = "SELECT ";
			for($i=0;$i < count($column);$i++) {
				if($i == 0){
					$sql = $sql .$column[$i];
				}else{
					$sql = $sql .", ".$column[$i];
				}
			}
			$sql = $sql ." FROM ".$instance->table;
		}else{
			$sql = "SELECT ".$column." FROM ".$instance->table;
		}

		if($orderBy != false){
			$sql = $sql . " order by " . $orderBy . " ". $orderWay;
		}
		if(is_array($limit)){
			if($limit != false){
				$sql = $sql . " limit ". $limit[0] . " , " . $limit[1];
			}
		}else{
			if($limit != false){
				$sql = $sql . " limit 0 , ". $limit;
			}
		}
		$sql = $sql.";";
		$query =  $instance->pdo->prepare($sql);

		$query->execute();
		$query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		$items = [];
		while($item = $query->fetch()) {
			$items[] = $item;
		}

		return $items;
	}

	public static function findById($id) {
		$instance = new static;
		$sql = "SELECT * FROM ".$instance->table;
		if (is_numeric($id)) {
			$sql = $sql." WHERE id=".$id.";";
			$query =  $instance->pdo->prepare($sql);
			$query->execute();
			$item = $query->fetch(PDO::FETCH_ASSOC);
			foreach ($item as $column => $value) {
				$instance->$column = $value;
			}
			return $instance;
		} else {
			return False;
		}
	}

	/**
	* Assign data from db to current object
	* @return bolean
	* @param $column string
	* @param $value string or numeric
	* @param $valueType string
	*/
	public static function findBy($column, $value, $valueType, $Orderby=false, $ParamOrder="id", $OrderWay="ASC") {
		$instance = new static;
		//Si il y a plusieurs columns a vérifier
		if(is_array($column) && is_array($value) && is_array($valueType)){
			$sql = "SELECT * FROM "
				.$instance->table." WHERE ";
			for($i=0;$i<count($column);$i++){
				if($i == 0){
					$sql = $sql . $column[$i];
				}else{
					$sql = $sql . " AND ".$column[$i];
				}
				if ($valueType[$i] == "string") {
					$sql = $sql."='".$value[$i]."'";
				}
				else if ($valueType[$i] == "int") {
					$sql = $sql."=".$value[$i];
				}
				if($i+1 == count($column)){
					if ($Orderby==true){
						$sql = $sql." ORDER BY ".$ParamOrder." ".$OrderWay." ;";
					} else{
						$sql = $sql." ;";
					}
				}
			}
			$query = $instance->pdo->prepare($sql);
			$query->execute();
		}else{ //Sinon on fait une simple requete sur une colonne
			$sql = "SELECT * FROM "
				.$instance->table." WHERE "
				.$column;
			if ($valueType == "string") {
				if ($Orderby==true){
					$sql = $sql."='".$value."' ORDER BY ".$ParamOrder." ".$OrderWay." ;";
				} else{
					$sql = $sql."='".$value."';";
				}
			}
			else if ($valueType == "int") {
				if ($Orderby==true){
					$sql = $sql."=".$value." ORDER BY ".$ParamOrder." ".$OrderWay." ;";
				} else{
					$sql = $sql."=".$value.";";
				}
			}
			$query = $instance->pdo->prepare($sql);
			$query->execute();
		}

		/*
			S'il y a une seule occurence on renvoie l'objet, s'il y en a plus on renvoie un array d'objet.
		*/

		$items = [];
		$query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
		while($item = $query->fetch()) {
			$items[] = $item;
		}

		return $items;

	}

	public function save()
	{
		if (is_numeric($this->id)) {
			$sql = "UPDATE ".$this->table." SET ";
			$len = count($this->columns);
			$i = 0;
			foreach ($this->columns as $column) {
				if ($i == $len - 1) {
					$sql = $sql.$column."=:".$column;
				} else {
					$sql = $sql.$column."=:".$column." ,";
				}
				$i ++;
			}
			$sql = $sql." WHERE id=".$this->id;
			$stmt = $this->pdo->prepare($sql);
			foreach ($this->columns as $column) {
				$stmt->bindValue(":".$column, $this->$column);
			}
			try {
				$stmt->execute();
				return $this->pdo->lastInsertId();
			} catch (Exception $e) {
				die("Error : ".$e->getMessage());
			}
		}
		else
		{
			$sql = "INSERT INTO ".$this->table." (".implode(",",$this->columns).")
					VALUES (:".implode(",:",$this->columns).")";
			$query = $this->pdo->prepare($sql);
			foreach ($this->columns as $column) {
				$data[$column] = $this->$column;
			}

			try {
				$query->execute($data);
				$this->id = $this->pdo->lastInsertId();
				return $this->pdo->lastInsertId();
			} catch (Exception $e) {
				die("Error while saving ".$e->getMessage());
			}
		}
	}

	public function delete(){
		if (isset($this->id)) {
			$sql = "DELETE from " . $this->table . " WHERE id = " . $this->id;
			$this->pdo->exec($sql);
		}
	}

	public static function findByLikeArray($columns,$search,$fetch=false) {
		$instance = new static;
		$sql = "SELECT * FROM ".$instance->table;
		$first = true;
		foreach ($columns as $column){
			if($first == true){
				$sql = $sql ." WHERE ".$column." LIKE '%".$search."%'";
				$first = false;
			}else{
				$sql = $sql ." OR ".$column." LIKE '%".$search."%'";
			}
		}
		$query =  $instance->pdo->prepare($sql);

		$query->execute();
		if($fetch == true){
			$item = $query->fetch(PDO::FETCH_ASSOC);
			if($item) {
				foreach ($item as $column => $value) {
					$instance->$column = $value;
				}
				return $instance;
			}
			else {
				return False;
			}
		}else{
			$item = $query->fetchAll();
			if($item) {
				return $item;
			}
			else {
				return False;
			}
		}
		return $items;
	}

	public static function findByLike($column, $value){
		$instance = new static;
		/*
		Requete verifiant le champs exact
		$sql = "SELECT * FROM ".$instance->table."";
		$query = $instance->pdo->prepare($sql);
		$query->execute();

		$result = [];

		while($row = $query->fetch()){
			$explode = explode(",",$row['tags']);
			foreach($explode as $valueExplode){
				if($valueExplode == $value){
					$result[] = $row;
				}
			}
		}

		if(count($result) == 1){
			return $result[0];
		}else{
			return $result;
		}
	}*/

	$sql = "SELECT * FROM "
	.$instance->table." WHERE "
	.$column;

	$sql = $sql." LIKE '%".$value."%';";
        $sql = $sql ." COLLATE utf8_general_ci";

	$query = $instance->pdo->prepare($sql);
	$query->execute();

	$items = [];
	$query->setFetchMode(PDO::FETCH_CLASS, get_called_class());
	while($item = $query->fetch()) {
		$items[] = $item;
	}

	return $items;

}

}
