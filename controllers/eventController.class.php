<?php

class eventController {

    public function listAction($args) {
        if (User::isConnected()) {
            $view = new View();
            $events = Event::findAll();

            $view->assign("events", $events);
            $view->setView("event/list.tpl");

        } else {
            header("location:" . WEBROOT);
        }
    }

    public function createAction($arg) {
        if (User::isConnected()) {
            $event = new Event();
            $form = $event->getForm("createEvent");
            $view = new View();
            $formErrors = [];
            if (!empty($_POST)) {
                $validator = new Validator();
                $formErrors = $validator->check($form["struct"], $_POST);
                if (count($formErrors) == 0) {
                    $event = new Event();
                    $currentUser = User::findById($_SESSION["user_id"]);
                    $event->setOwner($currentUser->getId());
                    $event->setOwnerName($currentUser->getUsername());
                    $event->setName(htmlspecialchars($_POST["name"]));
                    $unformatedDate = date_parse_from_format("d/mY", $_POST["from_date"]);
                    $from_date = new Datetime(
                        $unformatedDate["year"] . "-" .
                        $unformatedDate["month"] . "-" .
                        $unformatedDate["day"] . " " .
                        $_POST["from_time"]
                    );
                    $event->setFromDate($from_date->format("Y-m-d H:i"));
                    $unformatedDate = date_parse_from_format("d/m/Y", $_POST["to_date"]);
                    $to_date = new Datetime(
                        $unformatedDate["year"] . "-" .
                        $unformatedDate["month"] . "-" .
                        $unformatedDate["day"] . " " .
                        $_POST["to_time"]
                    );
                    $event->setToDate($to_date->format("Y-m-d H:i"));
                    $unformatedDate = date_parse_from_format("d/m/Y", $_POST["joignable_until"]);
                    $joignable_until = new Datetime(
                        $unformatedDate["year"] . "-" .
                        $unformatedDate["month"] . "-" .
                        $unformatedDate["day"] . " " .
                        $_POST["joignable_until_time"]
                    );
                    $event->setJoignableUntil($joignable_until->format("Y-m-d H:i"));
                    $event->setLocation(htmlspecialchars($_POST["location"]));
                    $event->setDescription(htmlspecialchars($_POST["description"]));
                    $event->setTags(htmlspecialchars($_POST["tags"]));
                    $event->setNbPeopleMax($_POST["nb_people_max"]);
                    $event->save();
                    $event->addUser($currentUser->getId());
                    header("location:" . WEBROOT . "event/list");
                }
            }
            $view->assign("form", $form);
            $view->assign("form_errors", $formErrors);
            $view->setView("event/create.tpl");
        } else {
            header("location:" . WEBROOT);
        }
    }

    public function updateAction($args) {
        if (User::isConnected()) {
            if ($event = Event::findById(intval($args[0]))) {
                if ($event->getOwner() == $_SESSION["user_id"]) {
                    $view = new View();
                    $form = $event->getForm("updateEvent");
                    $formErrors = [];
                    if (!empty($_POST)) {
                        $validator = new Validator();
                        $formErrors = $validator->check($form["struct"], $_POST);
                        if (count($formErrors) == 0) {
                            $currentUser = User::findById($_SESSION["user_id"]);
                            $event->setOwner($currentUser->getId());
                            $event->setOwnerName($currentUser->getUsername());
                            $event->setName(htmlspecialchars($_POST["name"]));
                            $unformatedDate = date_parse_from_format("d/m/Y", $_POST["from_date"]);
                            $from_date = new Datetime(
                            $unformatedDate["year"] . "-" .
                            $unformatedDate["month"] . "-" .
                            $unformatedDate["day"] . " " .
                            $_POST["from_time"]
                            );
                            $event->setFromDate($from_date->format("Y-m-d H:i"));
                            $unformatedDate = date_parse_from_format("d/m/Y", $_POST["to_date"]);
                            $to_date = new Datetime(
                            $unformatedDate["year"] . "-" .
                            $unformatedDate["month"] . "-" .
                            $unformatedDate["day"] . " " .
                            $_POST["to_time"]
                            );
                            $event->setToDate($to_date->format("Y-m-d H:i"));
                            $unformatedDate = date_parse_from_format("d/m/Y", $_POST["joignable_until"]);
                            $joignable_until = new Datetime(
                            $unformatedDate["year"] . "-" .
                            $unformatedDate["month"] . "-" .
                            $unformatedDate["day"] . " " .
                            $_POST["joignable_until_time"]
                            );
                            $event->setJoignableUntil($joignable_until->format("Y-m-d H:i"));
                            $event->setLocation(htmlspecialchars($_POST["location"]));
                            $event->setDescription(htmlspecialchars($_POST["description"]));
                            $event->setTags(htmlspecialchars($_POST["tags"]));
                            $event->setNbPeopleMax($_POST["nb_people_max"]);
                            $nameEvent = $event->getName();
                            $owner = $event->getOwner();
                            $users = $event->gatherUsers();
                            foreach ($users as $user){
                                $idUser = $user['id'];
                                if ($owner != $idUser){
                                    Notification::createNotification($idUser,$message="The event ".$nameEvent." has been edited !",$action=WEBROOT."event/list");
                                }
                            }
                            $event->save();
                            $event->addUser($currentUser->getId());
                        }
                    }
                    $view->assign("form", $form);
                    $view->assign("form_errors", $formErrors);
                    $view->assign("event", $event);
                    $view->setView("event/update.tpl");
                } else {
                    http_response_code(404);
                    Echo "Évènement introuvable";
                }
            } else {
                throw new Exception("Vous devez être le créateur de l'évènement.", 403);
            }
        } else {
            header("location:" . WEBROOT);
        }
    }

    public function deleteAction($args) {
        if ($event = Event::findById(intval($args[0]))) {
            $nameEvent = $event->getName();
            $users = $event->gatherUsers();
            foreach ($users as $user){
                $idUser = $user['id'];
                $owner = $event->getOwner();
                if ($owner != $idUser){
                    Notification::createNotification($idUser,$message="The event ".$nameEvent." has been deleted !",$action=WEBROOT);
                }
            }
            $event->delete();
            header("location:" . WEBROOT . "event/list");
        } else {
            http_response_code(404);
            Echo "Évènement introuvable";
        }
    }

    public function joinAction($args) {
        if (isset($args[0])) {
            $event = Event::findById(intval($args[0]));
            $event->addUser(intval($_SESSION["user_id"]));
            $idOwner = $event->getOwner();
            Notification::createNotification($idOwner,$message="Someone just joined your event, check it out !",$action=WEBROOT."event/update/".$args[0]);
            header("location:" . WEBROOT . "event/list");
        } else {
            http_response_code(404);
            echo "Évènement introuvable";
        }
    }

    public function joinTeamAction($args) {
        if (isset($args[0])) {
            $event = Event::findById(intval($args[0]));
            $user = User::findById($_SESSION['user_id']);

            $view = new View();
            $view->assign("user",$user);
            $view->setView("event/joinTeam.tpl");
            $view->assign("event",$event);
            if(isset($_SESSION['joinTeamFailed'])){
              $view->assign("error","Vous avez invités trop de membres !");
              unset($_SESSION['joinTeamFailed']);
            }
            /*$event->addUser(intval($_SESSION["user_id"]));
            $idOwner = $event->getOwner();
            Notification::createNotification($idOwner,$message="Someone just joined your event, check it out !",$action=WEBROOT."event/update/".$args[0]);*/
            //header("location:" . WEBROOT . "event/list");
        } else {
            http_response_code(404);
            echo "Évènement introuvable";
        }
    }

    public function joinTeamSuccessAction($args) {
        if (isset($args[0])) {
            $event = Event::findById(intval($args[0]));
            $place = $event->getPlaceRestante();
            if (count($_POST['participant'.$args[1]]) > $place){
              $_SESSION['joinTeamFailed'] = 1;
              header("location:" . WEBROOT . "event/joinTeam/".$args[0]);
            }else{
              foreach($_POST['participant'.$args[1]] as $participant){
                $event->addUser(intval($participant));
                $idOwner = $event->getOwner();
                Notification::createNotification($idOwner,$message="Un utilisateur vient de rejoindre votre évènement !",$action=WEBROOT."event/update/".$args[0]);
              }
            }
            header("location:" . WEBROOT . "event/list");
            /*$event->addUser(intval($_SESSION["user_id"]));
            $idOwner = $event->getOwner();
            Notification::createNotification($idOwner,$message="Someone just joined your event, check it out !",$action=WEBROOT."event/update/".$args[0]);*/
            //header("location:" . WEBROOT . "event/list");
        } else {
            http_response_code(404);
            echo "Évènement introuvable";
        }
    }


    public function leaveAction($args) {
        if (isset($args[0]) && isset($args[1])) {
            $event = Event::findById(intval($args[0]));
            $event->removeUser(intval($args[1]));
            $idOwner = $event->getOwner();
            Notification::createNotification($idOwner,$message="Someone just left your event, check it out !",$action=WEBROOT."event/update/".$args[0]);
            if ($event->getOwner() == $_SESSION["user_id"]) {
                header("location:" . WEBROOT . "event/update/" . $event->getId());
            } else {
                header("location:" . WEBROOT . "event/list");
            }
        } else {
            http_response_code(404);
            echo "Évènement ou utilisateur introuvable";
        }
    }

    public function searchAction($args)
    {
        header('Content-Type: application/json');
        $args = implode(",", $args);
        $args = explode(",", $args);
        $args1 = $args[0];
        $args2 = $args[1];
        $events = Event::findByLike($args1,$args2);
        $fullData = [];
        for ($i = 0; $i < count($events); $i++) {
          $fullData[$i] = [
            "eventName" => $events[$i]->getName(),
            "id" => $events[$i]->getId(),
            "eventFromDate" => $events[$i]->getFromDate(),
            "tags" => $events[$i]->getTags(),
            "description" => $events[$i]->getDescription(),
            "fromDate" => $events[$i]->getFromDate(),
            "toDate" => $events[$i]->gettoDate(),
            "joignableUntil" => $events[$i]->getJoignableUntil(),
            "ownerName" => $events[$i]->getOwnerName(),
            "owner" => $events[$i]->getOwner(),
            "users" => $events[$i]->gatherUsers()
          ];
        }
        echo json_encode($fullData);
    }

    public function showAction($args) {
        if (User::isConnected()) {
            if (!empty(htmlspecialchars(intval($args[0])))) {
                $event = Event::findById(htmlspecialchars(intval($args[0])));
                $users = $event->gatherUsers();
                $view = new View();
                $view->setView("event/show.tpl");
                $view->assign("event", $event);
                $view->assign("users", $users);
            } else {
                header("location:" . WEBROOT);
            }
        } else {
            header("location:" . WEBROOT);
        }
    }

    public function likeAction($args){
        if (User::isConnected()) {
            if (!empty($args)) {
              $helper = new Helpers();
              $event = EventHasVote::findBy(['idUser','idEvent'],[$_SESSION['user_id'],$args['idEvent']],['int','int']);
              if($event){
                if(!EventHasVote::findBy(['idUser','idEvent',"upOrDown"],[$_SESSION['user_id'],$args['idEvent'],$args['upOrDown']],['int','int','int'])){
                  $event[0]->setUpOrDown($args['upOrDown']);
                  $event[0]->save();
                  $classe = ".vote_area".$args["idEvent"];
                  $helper->getMessageAjaxForm("Vote changé !","like",$args['upOrDown'],$classe);
                }else{
                  $helper->getMessageAjaxForm("Vous avez déjà voté !");
                }
              }else{
                $event_has_votes = new EventHasVote();
                $event_has_votes->setIdUser($_SESSION['user_id']);
                $event_has_votes->setIdEvent($args['idEvent']);
                $event_has_votes->setUpOrDown($args['upOrDown']);
                $event_has_votes->save();
                $classe = ".vote_area".$args["idEvent"];
                $helper->getMessageAjaxForm("Evenement aimé !","like",$args['upOrDown'],$classe);
              }
            } else {
              header("location:" . WEBROOT);
            }
        } else {
            header("location:" . WEBROOT);
        }
    }

}
