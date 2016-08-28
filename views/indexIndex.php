<div class="row">
  <div class="col-sm-12">
    <div class="col-sm-4 col-sm-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading"><h2 class="center li-header">&Eacute;vènement promu</h2></div>
            <div class="panel-body">
                <?php
                if($eventFamous == null){
                    echo '<h1> Pas encore d\'évènement promu</h1>';
                }else{
                    foreach($eventFamous as $eventFamous){
                      $link = WEBROOT."event/show/".$eventFamous->getId();
                      echo '<a href="'.$link.'">'.$eventFamous->getName().'</a><br>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-sm-offset-1">
        <div class="panel panel-success">
            <div class="panel-heading"><h2 class="center li-header">&Eacute;vènement à proximité</h2></div>
            <div class="panel-body">
            <?php
              //si user ville pas définis -> message avec redirection ves profi ledition, Sinon in affiche les events avec la ville tmtc
              if($eventLocation == "unknow"){
                echo "Pour connaitre les évènements à proximité de toi, <a href='".WEBROOT."user/edit/".$_SESSION['user_id']."'>Clique ici</a> pour définir ta ville !";
              }else{
                foreach($eventLocation as $oneEvent){
                  $link = WEBROOT."event/show/".$oneEvent->getId();
                  echo '<a href="'.$link.'">'.$oneEvent->getName().'</a><br>';
                }
              }

              ?>
            </div>
        </div>
    </div>
  </div>
  <div class="col-sm-12">
    <div class="col-sm-4">
        <div class="panel panel-primary2">
            <div class="panel-heading"><h2 class="center li-header">10 derniers inscris</h2></div>
            <div class="panel-body">
                <?php
                    if($users == null){
                        echo '<h1> Pas d\'utilisateur pour le moment</h1>';
                    }else{
                        foreach($users as $user){
                          $link = WEBROOT."user/show/".$user->getId();
                          echo '<a href="'.$link.'">'.$user->getUsername().'</a><br>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-success">
            <div class="panel-heading"><h2 class="center li-header">10 dernières équipes</h2></div>
            <div class="panel-body">
                <?php
                    if($teams == null){
                        echo '<h1>Pas d\'équipes pour le moment</h1>';
                    }else{
                        foreach($teams as $team){
                          $link = WEBROOT."team/show/".$team->getId();
                          echo '<a href="'.$link.'">'.$team->getTeamName().'</a><br>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-warning">
            <div class="panel-heading"><h2 class="center li-header">10 derniers évènements</h2></div>
            <div class="panel-body">
              <?php
                  if($events == null){
                      echo '<h1> Pas d\'évènements pour le moment</h1>';
                  }else{
                      foreach($events as $event){
                        $link = WEBROOT."event/list";
                        echo '<a href="'.$link.'">'.$event->getName().'</a><br>';
                      }
                  }
              ?>
            </div>
        </div>
    </div>
</div>

    <?php
    // Pour créer une notif test
    //Notification::createNotification("blah blah notification de l'user ".$_SESSION['user_id']);
    ?>

</div>
