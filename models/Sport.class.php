<?php

class Sport extends basesql
{
    public $id;
    protected $table = "sports";
    public $name;

    protected $columns = [
        "id",
        "name",
    ];

    public function __construct(){
        parent::__construct();
    }

    public function getId() {
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }


    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name){
        $this->name = htmlspecialchars($name);
    }


};
