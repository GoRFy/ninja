<?php
if(isset($error)){
  echo '<div style="text-align:center;"><b style="color:red;font-size:20px">'.$error.'</b></div><br>';
}
 ?>

<div class="row" xmlns="http://www.w3.org/1999/html">
<div class="col-sm-12">
<?php
  foreach($user->getTeams() as $myTeam){
    $team = Team::findById($myTeam);
    $participants= [];
    foreach ($event->gatherUsers() as $key => $user){
      $participants[]=$user["username"];
    }
  echo '
  <div class="col-sm-6">
      <div class="panel panel-primary">
          <div class="panel-heading"><h3 class="center header-li "><a href="'.WEBROOT.'team/show/'.$team->getId().'"> '.$team->getTeamName().'</a></h3></div>

          <div class="panel-body">
          <div>Vous ne pouvez enregistrer plus de '.$event->getPlaceRestante().' membres.</div>
              <ul class="header-ul">
                  <li class="li-list">
                      <span class="form-info">Membres : <br></span><form action="'.WEBROOT.'event/joinTeamSuccess/'.$event->getId().'/'.$team->getId().'" method="post">
                      ';
                      foreach($team->getMembers() as $member){
                          $user = User::findById($member);
                          if(in_array($user->getUsername(),$participants)){
                              echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="form-content" style="text-decoration: line-through;">'.$user->getUsername().'</span> (Déja inscris)';
                          }else{
                              echo '<span class="form-content"><input type="checkbox" name="participant'.$team->getId().'[]"  value='.$user->getId().'>'.$user->getUsername().'</span>';
                          }

                          echo '<br>';
                      }
                      echo '<div class=" input-grp text-right"><input type="submit" class=" btn btn-primary" value="S\'inscrire"></div>';
                    echo '</form>
                  </li>';

                  echo '
              </ul>
          </div>
      </div>
  </div>';
  //http://localhost:8080/ninja/event/joinTeamSuccess/2?participant91=GoRFy&participant91=GoRFy3
}
?>

</div>
</div>
