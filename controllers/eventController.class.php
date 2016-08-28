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
            $form = Event::getForm("createEvent");
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
                    Echo "Event not found.";
                }
            } else {
                throw new Exception("You must be owner of the event.", 403);
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
            Echo "Event not found.";
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
            echo "Event not found";
        }
    }

    public function commentAction($args){
      if(User::isConnected() && !empty($args[0])){
        $event = Event::findById($args[0]);
        $view = new View();
        $commentForm = $event->getForm("comment");
        $commentErrors = [];
        $comments = EventHasComment::FindBy("id_event",$args[0],"int");
        $total = count($comments);//Nombre de team
        $messagesParPage=10; //Nombre de messages par page
        $nombreDePages=ceil($total/$messagesParPage);

        if(isset($_GET['page'])){
             $pageActuelle=intval($_GET['page']);
             if($pageActuelle>$nombreDePages)
             {
                  $pageActuelle=$nombreDePages;
             }
        }else{
             $pageActuelle=1;
        }
        $premiereEntree=($pageActuelle-1)*$messagesParPage;
        // La requête sql pour récupérer les messages de la page actuelle.
        $retour_messages= Comment::findAll([$premiereEntree,$messagesParPage],'id');
        if(!empty($_POST)) {
  				$validator = new Validator();
  				$commentErrors = $validator->check($commentForm["struct"], $_POST);
  				if(count($commentErrors) == 0) {
            $comment = new Comment;
            $now = date("Y-m-d H:i:s");
            $comment->setDateCreated($now);
            $comment->setComment($_POST['comment']);
            $comment->setIdAuthor($_SESSION['user_id']);
            $comment->save();

            $eventHasComment = new EventHasComment;
            $eventHasComment->setIdEvent($args[0]);
            $eventHasComment->setIdComment($comment->getId());
            $eventHasComment->save();
          }
        }

        $view->assign("commentForm",$commentForm);
        $view->assign("commentErrors",$commentErrors);
        $view->setView("event/comment.tpl");
        $view->assign("comments",$retour_messages);
        $view->assign("event", $event);
      }else{
        //A voir la redirection
        header('Location:'.WEBROOT.'user/login');
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
            echo "User or event not found";
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
