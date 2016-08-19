<?php

class sportController
{
    public function getSportsAction($args)
    {
        header('Content-Type: application/json');
        $args1 = $args[0];
        $columns = ["name"];
        $args1 = urldecode($args1);
        $sports = Sport::findByLikeArray($columns,$args1);
        echo json_encode($sports);
    }


    public function searchAction($args)
    {
        $view = new View();
        $view->setView("testing.tpl");
    }
}