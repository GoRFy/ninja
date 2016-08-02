<?php
$team = $this->data["team"];
$captain = $this->data["captain"];
//Se l'utilisateur y accede par URL, mais n'a pas les droit ont le redirige
if(!$team->getId() == ""){
  if(!Team::imIn($team->getId())){
    header('Location:'.WEBROOT.'user/login');
  }
}
?>

<div class="row">
  <div class="col-sm-10 col-sm-offset-1">
    <div class="panel panel-primary">
      <?php if(!$team->getTeamName()):?>
        <div class="panel-body">
          <h3>Team not found</h3>
        </div>
      <?php else : ?>
        <!-- IMAGE EQUIPE

        <div class="panel-media">
        <img src="<?= WEBROOT; ?>dist/images/monkey.jpg">
      </div>
    -->
    <div class="panel-heading"><h3 class="center header-li"> Gérer mon équipe</h3></div>
    <div class="panel-body">
      <p>Nom d'équipe : <?= $team->getTeamName(); ?></p>
      <?php
      $dateCreation = $team->getDateCreated();
      $mois = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
      $date = date("d ",strtotime($dateCreation)). $mois[(date("n ",strtotime($dateCreation))- 1)]. date(" Y à H:i",strtotime($dateCreation));
      ?>
      <p>Date de création : <?= $date; ?></p>
      <p>Description : <?= $team->getDescription(); ?></p>
      <div class="text-left">
        <a href="<?= WEBROOT;?>team/show/<?= $team->getId();?>"class="btn btn-primary">Voir</a>
        <?php if($captain[0]->getCaptain() >=1) : ?>
          <a href="<?= WEBROOT;?>team/edit/<?= $team->getId();?>"class="btn btn-primary">Modifier</a>
        <?php endif; ?>
        <?php if($captain[0]->getCaptain() > 0): ?>
          <a href="<?= WEBROOT;?>team/invite/<?= $team->getId();?>"class="btn btn-primary">Inviter</a>
        <?php endif; ?>
          <div class="pull-right">
            <a href="#" data-team="<?php echo $team->getId(); ?>" class="btn btn-danger ajax-link " data-url="team/leave">Quitter</a><?php if($captain[0]->getCaptain() >= 2) : ?>&nbsp;<a href="#" data-url="team/delete" data-team="<?= $team->getId(); ?>" class="ajax-link btn btn-danger">Supprimer mon équipe</a><?php endif; ?>
          </div>
        <br><br>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-10 col-sm-offset-1">
    <div class="col-sm-7">
      <div class="panel panel-primary">
        <div class="panel-heading"><h4 class="center header-li"> Membres </h4></div>
        <div class="panel-body">
          <?php
          $myself = User::findById($_SESSION['user_id']);
          $myself = Captain::findBy(["idUser","idTeam"],[$myself->getId(),$team->getId()],["int","int"]);
          foreach($members as $member){
            $user = User::findById($member->getIdUser());
            $actualUserAdmin = Captain::findBy(["idUser","idTeam"],[$user->getId(),$team->getId()],["int","int"]);
            echo "<br>".$user->getUsername()." - " . Captain::getTitre($actualUserAdmin[0]->getCaptain());
            if(!($user->getId() == $_SESSION["user_id"])){ ?>
              <?php if($captain[0]->getCaptain() >= 2 ): ?>
                <?php if($actualUserAdmin[0]->getCaptain() != 2 && $actualUserAdmin[0]->getCaptain() >= 0 ): ?>
                  <a href="#" data-url="team/promote" data-team="<?= $team->getId()?>" data-user="<?= $user->getId()?>" class="ajax-link" > - Promouvoir</a>
                <?php endif; ?>
                <?php if(($actualUserAdmin[0]->getCaptain() != 2 && $actualUserAdmin[0]->getCaptain() > 0) || $myself[0]->getCaptain() == 3): ?>
                  <a href="#" data-url="team/demote" data-team="<?= $team->getId()?>" data-user="<?= $user->getId()?>" class="ajax-link"> - Rétrograder</a>
                <?php endif; ?>
                <?php if($actualUserAdmin[0]->getCaptain() != 2  || $myself[0]->getCaptain() == 3): ?>
                  <a href="#" data-url="team/kick" data-team="<?= $team->getId()?>" data-user="<?= $user->getId()?>" class="ajax-link" > - Exclure</a>
                <?php endif; ?>
                <?php if($myself[0]->getCaptain() == 3) :?>
                  <a href="#" > - Donnez le lead</a>
                <?php endif; ?>
              <?php endif; ?>
              <?php
            }

          }
          ?>
        </div>
      </div>
    </div>
    <div class="col-sm-5">
      <div class="col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading"><h4 class="center header-li"> Invitations en attente </h4></div>
          <div class="panel-body">
            <?php if(count($invitationsTo) > 0) : ?>
              <?php
              foreach($invitationsTo as $invitedOne){
                $dateCreation =  $invitedOne->getDateInvited();
                $mois = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
                $date = date("d ",strtotime($dateCreation)). $mois[(date("n ",strtotime($dateCreation))- 1)]. date(" Y à H:i",strtotime($dateCreation));

                $userInvited = User::FindById($invitedOne->getIdUserInvited());
                ?>
                Vous avez invité <b><a href="<?= WEBROOT?>user/show/<?= $userInvited->getId()?>"><?= $userInvited->getUsername(); ?></a></b>le <?=$date;?> - <a href="#" data-url="team/cancelInvitation" data-team=<?= $invitedOne->getIdTeamInviting()?> data-user=<?= $userInvited->getId()?> class="ajax-link btn btn-danger"><span class="fa fa-remove"></span></a>
                <?php
                echo '<BR>'; // SWAG TU AIMES BIEN RENAUD ? :(
              }

              ?>
            <?php else: ?>
              <h4 class="center">Aucune pour le moment</h4>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="panel panel-primary">
          <div class="panel-heading"><h4 class="center header-li"> Demande d'adhésion </h4></div>
          <div class="panel-body">
            <?php if(count($invitationsFrom) > 0): ?>
              <?php
              foreach($invitationsFrom as $invitedOne){
                $dateCreation =  $invitedOne->getDateInvited();
                $date = date("d/m/y H:i",strtotime($dateCreation));

                $userInvited = User::FindById($invitedOne->getIdUserInvited());
                echo "<div style='text-align:center'>".$date." - " .$userInvited->getUsername().'&nbsp;<a href="#" data-url="team/join" data-team='.$invitedOne->getIdTeamInviting().' data-type='.$invitedOne->getType().' data-user='.$userInvited->getId().' class="ajax-link btn btn-success"><span class="fa fa-check">&nbsp;</span></a>&nbsp;
                <a href="#" class="ajax-link btn btn-danger" data-url="team/cancelInvitation" data-team='.$invitedOne->getIdTeamInviting().' data-user='.$userInvited->getId().' data-type='.$invitedOne->getType().'><span class="fa fa-remove" >&nbsp;</span></a><br>'.$invitedOne->getMessage().'</div>';
                echo '<BR>'; // SWAG TU AIMES BIEN RENAUD ? :(
              }

              ?>
            <?php else: ?>
              <h4 class="center">Aucune pour le moment</h4>
            <?php endif; ?>
            <!--
            AFFICHER DERNIER EVENT ?
            EVENT RECURRENT ?
          -->
        </div>
      <?php endif;?>
    </div>
  </div>
</div>
