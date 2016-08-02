<?php
$user = $this->data["user"];
?>

<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-primary2">
      <?php if(!$user->getUsername()):?>
        <div class="panel-body">
          <h3>Utilisateur introuvable</h3>
        </div>
      <?php else : ?>


        <div class="panel-heading"><h3 class="center header-li"> Profil de  <?php echo $user->getUsername(); ?></h3></div>
        <?php if($user->getAvatar() != ""): ?>
          <div class="panel-media">
            <img class="avatar" src="<?= "../../".$user->getAvatar(); ?>" style="width:100px;height:100px">
          </div>
        <?php endif;?>
        <div class="panel-body">
          <div class="col-sm-12">
            <div class="col-sm-6">
              <ul class="header-ul">
                <li class="li-list fa fa-user"> Personnel</li>
                <li class="li-list">
                  <span class="form-info">Prénom : </span>
                  <span class="form-content"><?php echo $user->getFirstName(); ?></span>
                </li>
                <li class="li-list">
                  <span class="form-info">Nom : </span>
                  <span class="form-content"><?php echo $user->getLastName(); ?></span>
                </li>
                <li class="li-list">
                  <span class="form-info">Sports préférés : </span>
                  <span class="form-content"><?php echo $user->getFavoriteSports(); ?></span>
                </li>
                <li class="li-list">
                  <span class="form-info">Age : </span>
                  <?php if($user->getBirthday() != "0000-00-00"): ?>
                    <span class="form-content"><?php echo User::getAge($user->getBirthday()); ?> ans</span>
                  <?php endif; ?>
                </li>
              </ul>
            </div>
            <div class="col-sm-6">
              <ul class="header-ul">
                <li class="li-list"><span class=" fa fa-phone"></span> <span class=" fa fa-at"></span> Contact</li>
                <li class="li-list">
                  <span class="form-info">Adresse email : </span>
                  <span class="form-content"><?php echo $user->getEmail(); ?></span>
                </li>
                <li class="li-list">
                  <span class="form-info">Numéro de téléphone : </span>
                  <span class="form-content"><?php echo $user->getPhoneNumber(); ?></span>
                </li>
                <li class="li-list">
                  <span class="form-info">Ville : </span>
                  <span class="form-content"><?php echo $user->getCity(); ?></span>
                </li>
              </ul>
            </div>
          </div>
        <?php endif;?>
        <?php if(User::itsMy($idUser)): ?>
          <div class="text-right">
            <a href="<?= WEBROOT; ?>user/edit/<?php echo $user->getId(); ?>" class="btn btn-primary">Edit</a>
          </div>
        <?php else: ?>
          <a>&nbsp;</a>
        <?php endif; ?>
      </div>
    </div>
    <div class="panel panel-primary2">
      <div class="panel-heading"><h3 class="center header-li"> Profil de  <?php echo $user->getUsername(); ?></h3></div>
      <div class="panel-body">
        <div class="col-sm-12">
          <div class="col-sm-6">
            <ul class="header-ul">
              <?php if(!empty($teams)){ ?>
                <li><span class="fa fa-users"> Équipes</span></li>
                <?php
                foreach($teams as $team){
                  $Team = Team::findById($team->getIdTeam());
                  echo '
                  <li class="li-list">
                  <span class="form-content"><a href="'.WEBROOT.'team/show/'.$Team->getId().'">'.$Team->getTeamName().'</a></span>
                  </li>
                  ';
                }
                ?>
                <?php }else{ ?>
                  <li class="li-list">Aucune équipe</li>
                  <?php } ?>
                </ul>
              </div>
              <div class="col-sm-6">
                <ul class="header-ul">
                  <?php if(!empty($events)){ ?>
                    <li><span class="fa fa-calendar-check-o"> Évènements</span></li>
                    <?php
                    foreach($events as $event){

                      echo $event->getName();

                    }
                    ?>
                  </li>
                  <?php } ?>
                </ul>
              </div>
            </div>
            <div class="text-right">
              <a href="#">&nbsp;</a>
            </div>
          </div>
        </div>
      </div>
    </div>
