<?php

class indexController
{
	public function indexAction($args)
	{
		if (User::isConnected()) {
			$view = new View;
			$view->setView("indexIndex");

						$teams = Team::FindAll(10,"dateCreated",["teamName","id"]);
            $view->assign("teams", $teams);

			//$notifications = Notification::findBy(["id_user","opened"],[$_SESSION['user_id'],0],['int','int'],false);
            //$view->assign("notifications", $notifications);

            $users = User::findAll(10,"dateCreated",["username","id"]);
            $view->assign("users",$users);

						$events = Event::findAll(10,"id",["name","id"]);
						$view->assign("events",$events);

						$eventsPromoted = EventHasVote::getMaxVoted();
						$eventPromoted = Event::findBy('id',$eventsPromoted,"int");
						$view->assign("eventFamous",$eventPromoted);

		} else {
	   		header("location: ".WEBROOT."landing/welcome");
		}
	}
}
