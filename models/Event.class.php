<?php

    class Event extends basesql {

        protected $id;
        protected $table = "events";
        protected $pivot_table = "events_users_pivot";
        protected $name;
        protected $from_date;
        protected $to_date;
        protected $joignable_until;
        protected $tags;
        protected $owner;
        protected $owner_name;
        protected $description;
        protected $location;
        protected $nb_people_max;
        protected $city = "";
        protected $zipcode =0;
        protected $country = "";

        protected $columns = [
            "id",
            "name",
            "from_date",
            "to_date",
            "joignable_until",
            "tags",
            "owner",
            "owner_name",
            "description",
            "location",
            "nb_people_max",
            "city",
            "country",
            "zipcode",
        ];


        /**
         * return id attribute
         * @return int
         */
        public function getId() {
            return $this->id;
        }

        /**
         * return name attribute
         * @return string
         */
        public function getName() {
            return $this->name;
        }

        /**
         * return from_date attribute
         * @return datetime
         */
        public function getFromDate() {
            return $this->from_date;
        }

        /**
         * return to_date attribute
         * @return datetime
         */
        public function getToDate() {
            return $this->to_date;
        }

        /**
         * return joignable_until attribute
         * @return datetime
         */
        public function getJoignableUntil() {
            return $this->joignable_until;
        }

        /**
         * return tags attribute
         * @return string
         */
        public function getTags() {
            return $this->tags;
        }

        /**
         * return users attribute
         * @return array
         */
        public function getUsers() {
            return $this->users;
        }

        /**
         * return owner attribute
         * @return int
         */
        public function getOwner() {
            return $this->owner;
        }

        /**
         * return owner_name attribute
         * @return string
         */
        public function getOwnerName() {
            return $this->owner_name;
        }

        /**
         * return description attribute
         * @return string
         */
        public function getDescription() {
            return $this->description;
        }

        /**
         * return location attribute
         * @return string
         */
        public function getLocation() {
            return $this->location;
        }

        /**
         * return nb_people_max attribute
         * @return int
         */
        public function getNbPeopleMax() {
            return $this->nb_people_max;
        }

        /**
         * return City attribute
         * @return int
         */
      	public function getCity(){
      		return $this->city;
      	}

        /**
         * return Zipcode attribute
         * @return int
         */
      	public function getZipcode(){
      		return $this->zipcode;
      	}

        /**
         * return getCountry attribute
         * @return int
         */
      	public function getCountry(){
      		return $this->country;
      	}

        /**
         * Set id attribute
         * @param int $id
         */
        public function setId($id) {
            $this->id = $id;
        }

        /**
         * Set name attribute
         * @param string $name
         */
        public function setName($name) {
            $this->name = $name;
        }

        /**
         * Set from_date attribute
         * @param datetime $date
         */
        public function setFromDate($date) {
            $this->from_date = $date;
        }

        /**
         * Set to_date attribute
         * @param datetime $date
         */
        public function setToDate($date) {
            $this->to_date = $date;
        }

        /**
         * Set joignable_until attribute
         * @param datetime $date
         */
        public function setJoignableUntil($date) {
            $this->joignable_until = $date;
        }

        /**
         * Set tags attribute
         * @param string $tags
         */
        public function setTags($tags) {
            $this->tags = $tags;
        }

        /**
         * Set owner attribute
         * @param int $id
         */
        public function setOwner($id) {
            $this->owner = $id;
        }

        /**
         * Set owner_name attribute
         * @param string $id
         */
        public function setOwnerName($name) {
            $this->owner_name = $name;
        }

        /**
         * Set description attribute
         * @param string $description
         */
        public function setDescription($description) {
            $this->description = $description;
        }

        /**
         * Set location attribute
         * @param string $location
         */
        public function setLocation($location) {
            $this->location = $location;
        }

        /**
         * Set nb_people_max attribute
         * @param int $max
         */
        public function setNbPeopleMax($max) {
            $this->nb_people_max = $max;
        }

        /**
         * Set City attribute
         * @param string $city
         */
        public function setCity($city){
          $this->$city = $city;
        }

        /**
         * Set Zipcode attribute
         * @param int $zipcode
         */
        public function setZipcode($zipcode){
          $this->zipcode = $zipcode;
        }

        /**
         * Set Country attribute
         * @param string $country
         */
        public function setCountry($country){
          $this->country = $country;
        }

        public function getNbPeople(){
          $nbPeopleMax = $this->getNbPeopleMax();
          //$event->gatherUsers();
          return count($this->gatherUsers());
        }

        public function getPlaceRestante(){
          return $this->getNbPeopleMax() - $this->getNbPeople();
        }

        /**
         * Return occurences of the relation
         * @return array of User
         */
        public function gatherUsers() {
            $pivot = new ManyToManyPivot(
                $this->pivot_table,
                "event",
                "user",
                $this->id
            );
            return $pivot->getData();
        }

        /**
         * Add user to event
         * @param [int] $id
         */
        public function addUser($id) {
            if (is_numeric(intval($id))) {
                $pivot = new ManyToManyPivot(
                    $this->pivot_table,
                    "event",
                    "user",
                    $this->id,
                    intval($id)
                );
                $pivot->save();
            }
        }

        /**
         * Remove User from event
         * @param [int] $id
         */
        public function removeUser($id) {
            if (is_numeric(intval($id))) {
                $pivot = new ManyToManyPivot(
                    $this->pivot_table,
                    "event",
                    "user",
                    $this->id,
                    intval($id)
                );
                $pivot->delete();
            }
        }

        /**
         * return array with event's user ids
         * @return [array]
         */
        public function getUsersId() {
            $ids = [];
            foreach ($this->gatherUsers() as $key => $user) {
                $ids[] = $user["id"];
            }
            return $ids;
        }

        /**
         * return splitted tag list
         * @return [array]
         */
        public function getTagArray() {
            return split(",", $this->getTags());
        }

        /**
         * Serialize tags
         * @param  [array] $tags
         */
        public function serializeTags($tags) {
            if (is_array($tags)) {
                $this->setTags(join(",", $tags));
            }
        }

        /**
         * Return formated time or date
         * @param  [string] $type
         * @param  [string] $datetime
         * @return [string]
         */
        public function getFormatedDateTime($type, $datetime) {
            $datetime = new Datetime($datetime);
            if ($type == "date") {
                return $datetime->format("d/m/Y");
            } else if ($type == "time") {
                return $datetime->format("H:i");
            }
        }

        /**
         * Return form structure.
         * @param string $formType
         * @return array
         */
        public function getForm($formType) {

            $form = [];

            if ($formType == "createEvent") {
                $form = [
    				"title" => "Créer votre évènement",
    				"buttonTxt" => "Créer",
    				"options" => ["method" => "POST", "action" => WEBROOT . "event/create", "class" => "", "data-attributes" => []],
    				"struct" => [
    					"name"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Nom", "required"=>1, "msgerror"=>"" ],
                        "description"=>[ "type"=>"textarea", "class"=>"form-control", "placeholder"=>"Description", "required"=>0, "msgerror"=>"" ],
    					"from_date" => ["type" => "text", "placeholder" => "Du (jour)", "required" => 1, "msgerror" => "date_format", "class" => "form-control js-time-input js-date"],
                        "from_time" => ["type" => "text", "placeholder" => "à (heure)", "required" => 1, "msgerror" => "time_format", "class" => "form-control js-time-input js-time"],
                        "to_date"=>[ "type"=>"text", "class"=>"form-control js-time-input js-date", "placeholder"=>"Jusqu'au (jour)", "required"=>1, "msgerror"=>"date_format" ],
                        "to_time" => ["type" => "text", "placeholder" => "à (heure)", "required" => 1, "msgerror" => "time_format", "class" => "form-control js-time-input js-time"],
                        "joignable_until" => ["type" => "text", "placeholder" => "Inscription ouverte du (jour)", "required" => 1, "msgerror" => "date_format", "class" => "form-control js-time-input js-date"],
                        "joignable_until_time" => ["type" => "text", "placeholder" => "à (heure)", "required" => 1, "msgerror" => "time_format", "class" => "form-control js-time-input js-time"],
                        "location" => ["type" => "text", "placeholder" => "Emplacement", "required" => 1, "msgerror" => "", "class" => "form-control"],
                        "nb_people_max" => ["type" => "number", "placeholder" => "Nombre maximum de participants", "required" => 1, "msgerror" => "", "class" => "form-control"],
                        "tags" => ["type" => "text", "placeholder" => "Tags", "required" => 1, "msgerror" => "", "class" => "form-control"],
    				]
    			];
            } else if ($formType == "updateEvent") {
                $form = [
    				"title" => "Modifier votre évènement",
    				"buttonTxt" => "Modifier",
                    "deletable" => $this->getId(),
    				"options" => ["method" => "POST", "action" => WEBROOT . "event/update/" . $this->getId(), "class" => "", "data-attributes" => []],
    				"struct" => [
    					"name"=>[ "type"=>"text", "class"=>"form-control", "placeholder"=>"Nom", "required"=>1, "msgerror"=>"", "value" => $this->getName()],
                        "description"=>[ "type"=>"textarea", "class"=>"form-control", "placeholder"=>"Description", "required"=>0, "msgerror"=>"", "value" => $this->getDescription() ],
    					"from_date" => ["type" => "text", "placeholder" => "Du (jour)", "required" => 1, "msgerror" => "date_format", "class" => "form-control js-time-input js-date", "value" => $this->getFormatedDateTime("date", $this->getFromDate())],
                        "from_time" => ["type" => "text", "placeholder" => "à (heure)", "required" => 1, "msgerror" => "time_format", "class" => "form-control js-time-input js-time", "value" => $this->getFormatedDateTime("time", $this->getFromDate())],
                        "to_date"=>[ "type"=>"text", "class"=>"form-control js-time-input js-date", "placeholder"=>"Jusqu'au (jour)", "required"=>1, "msgerror"=>"date_format", "value" => $this->getFormatedDateTime("date", $this->getToDate())],
                        "to_time" => ["type" => "text", "placeholder" => "à (heure)", "required" => 1, "msgerror" => "time_format", "class" => "form-control js-time-input js-time", "value" => $this->getFormatedDateTime("time", $this->getToDate())],
                        "joignable_until" => ["type" => "text", "placeholder" => "Inscription ouverte du (jour)", "required" => 1, "msgerror" => "date_format", "class" => "form-control js-time-input js-date", "value" => $this->getFormatedDateTime("date", $this->getJoignableUntil())],
                        "joignable_until_time" => ["type" => "text", "placeholder" => "à (heure)", "required" => 1, "msgerror" => "time_format", "class" => "form-control js-time-input js-time", "value" => $this->getFormatedDateTime("time", $this->getJoignableUntil())],
                        "location" => ["type" => "text", "placeholder" => "Emplacement", "required" => 1, "msgerror" => "", "class" => "form-control", "value" => $this->getLocation()],
                        "nb_people_max" => ["type" => "number", "placeholder" => "Nombre maximum de participants", "required" => 1, "msgerror" => "", "class" => "form-control", "value" => $this->getNbPeopleMax()],
                        "tags" => ["type" => "text", "placeholder" => "Tags", "required" => 1, "msgerror" => "", "class" => "form-control", "value" => $this->getTags()],
    				]
    			];
            }




            return $form;
        }

    }
