<?php

    class Contact extends basesql {

      protected $columns = [

      ];


      public function getForm(){

        $form = [
          "title" => "Nouveau ticket",
          "buttonTxt" => "Nous contacter",
          "options" => ["method" => "POST", "action" => WEBROOT . "user/subscribe"],
          "struct" => [
            "Sujet"=>[ "type"=>"text", "class"=>"form-control", "required"=>1,"placeholder"=>"Sujet", "msgerror"=>"useless"],
            "Email"=>["type"=>"email","class"=>"form-control", "required"=>1,"placeholder"=>"Email",  "msgerror"=>"email"],
            "message"=>[ "type"=>"textarea", "class"=>"form-control ", "required"=>1,"placeholder"=>"Message",  "msgerror"=>"useless"],
            "form-type" => ["type" => "hidden", "value" => "subscription", "placeholder" => "", "required" => 0, "msgerror" => "hidden input", "class" => ""
            ]
          ]
        ];

        return $form;
      }

    }

?>
