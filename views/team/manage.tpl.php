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
  <div class="col-sm-12">
  <div class="col-sm-7">
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
    <div class="panel-heading"><div class="center li-header" style="font-size:20px">Gérer mon équipe</div></div>
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

  <div class="col-sm-5">
    <div class="panel panel-primary">
      <div class="panel-heading"><div class="center li-header" style="font-size:18px">Invitations en attente </div></div>
      <div class="panel-body">
        <?php if(count($invitationsTo) > 0) : ?>
          <?php
          $i=0;
          foreach($invitationsTo as $invitedOne){
            echo '<div class="invitationsTo">';
            $dateCreation =  $invitedOne->getDateInvited();
            $mois = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
            $date = date("d ",strtotime($dateCreation)). $mois[(date("n ",strtotime($dateCreation))- 1)]. date(" Y à H:i",strtotime($dateCreation));

            $userInvited = User::FindById($invitedOne->getIdUserInvited());

            echo "<div style='text-align:center;font-size:14px;inline-block;line-height:25px'>Vous avez invité &nbsp; <a href=".WEBROOT."user/show".$userInvited->getId()."><b>" .$userInvited->getUsername()."</b></a>&nbsp; le ".$date.'
            &nbsp;<i href="#" class="icon-fixed-width ajax-link btn-danger fa fa-remove fa-fw icons-primary" data-url="team/cancelInvitation" data-team='.$invitedOne->getIdTeamInviting().' data-user='.$userInvited->getId().' data-type='.$invitedOne->getType().' aria-hidden="true"></i></div>';
            $i++;
            echo '</div>';
          }
          ?>
        <div id="pagination">
        </div>
        <?php else: ?>
          <h4 class="center">Aucune pour le moment</h4>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="col-sm-12">
  <div class="col-sm-7">
    <div class="panel panel-primary">
      <div class="panel-heading"><div class="center li-header" style="font-size:18px">Membres </div></div>
      <div class="panel-body">
        <?php
        $myself = User::findById($_SESSION['user_id']);
        $myself = Captain::findBy(["idUser","idTeam"],[$myself->getId(),$team->getId()],["int","int"]);
        foreach($members as $member){
          $user = User::findById($member->getIdUser());
          $actualUserAdmin = Captain::findBy(["idUser","idTeam"],[$user->getId(),$team->getId()],["int","int"]);
          echo '<p class="members" style="font-size:14px;">'.$user->getUsername()." - " . Captain::getTitre($actualUserAdmin[0]->getCaptain());
          if(!($user->getId() == $_SESSION["user_id"])){ ?>
            <?php if($captain[0]->getCaptain() >= 2 ): ?>
              <?php if($actualUserAdmin[0]->getCaptain() != 2  || $myself[0]->getCaptain() == 3): ?>
                <i href="#" data-url="team/kick" data-team="<?= $team->getId()?>" data-user="<?= $user->getId()?>" aria-hidden="true" class="icons-primary2 ajax-link btn-danger fa fa-remove fa-lg confirm" ></i>&nbsp;
                <!-- <a href="#" data-url="team/kick" data-team="<?= $team->getId()?>" data-user="<?= $user->getId()?>" class="ajax-link" > - Exclure</a> -->
              <?php endif; ?>
              <?php if($myself[0]->getCaptain() == 3) :?>
                <i href="#" data-url="team/kick" data-team="<?= $team->getId()?>" data-user="<?= $user->getId()?>" aria-hidden="true" class="icons-primary2 ajax-link btn-primary fa fa-star fa-lg confirm" ></i>&nbsp;
                <!-- <a href="#" > - Donnez le lead</a> -->
              <?php endif; ?>
            <?php endif; ?>
            <?php
          }
          echo '</p>';
        }
        ?>
      </div>
    </div>
  </div>
  <div class="col-sm-5">
    <div class="panel panel-primary">
      <div class="panel-heading"><div class="center li-header" style="font-size:18px"> Demande d'adhésion </div></div>
      <div class="panel-body">
        <?php if(count($invitationsFrom) > 0): ?>
          <?php
          $i=0;
          foreach($invitationsFrom as $invitedOne){
            $dateCreation =  $invitedOne->getDateInvited();
            $date = date("d/m/y H:i",strtotime($dateCreation));

            $userInvited = User::FindById($invitedOne->getIdUserInvited());
            echo "<div style='text-align:left;font-size:14px;inline-block'>".$date." - " .$userInvited->getUsername().'<div style="float:right"><i href="#" data-url="team/join" data-team='.$invitedOne->getIdTeamInviting().' data-type='.$invitedOne->getType().' data-user='.$userInvited->getId().' aria-hidden="true" class="icons-primary icon-fixed-width ajax-link btn-success fa fa-check fa-fw" ></i>&nbsp;
            <i href="#" class="icon-fixed-width ajax-link btn-danger fa fa-remove fa-fw icons-primary" data-url="team/cancelInvitation" data-team='.$invitedOne->getIdTeamInviting().' data-user='.$userInvited->getId().' data-type='.$invitedOne->getType().' aria-hidden="true"></i></div></div><br><div class="center" style="font-size:14px">'.$invitedOne->getMessage().'</div>';
            if($i < (count($invitationsFrom)-1) ){
              echo '<BR><HR style="width:70%"><BR>'; // SWAG TU AIMES BIEN RENAUD ? :(
            }
            $i++;
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
</div>
</div>
</div>
</div>
<div class="row modalPopup" id="confirmPopup" class="popup_block">
  <div class="col-sm-12">
    <div class="panel panel-primary">
      <div class="panel-body">
        <form id="confirmPopupForm">
          <div style="font-size:30px;color: black;padding-bottom:20px">Êtes-vous sûr ?</div>
          <div class="text-right">
            <input type="button" name="action" id="validate" value="Oui" class=" btn btn-success" />&nbsp;&nbsp;
            <input type="button" name="action" id="cancel" value="Non" class="btn btn-danger" />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
  <?php endif;?>
  <script>
$(document).ready(function() {
  pagination(3,".invitationsTo","#pagination",1);
});
</script>
