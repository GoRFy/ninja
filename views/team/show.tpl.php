<?php
$team = $this->data["team"];
?>

<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-primary">
            <?php if($team->getId() == null):?>
            <div class="panel-body">
                <h3>Équipe introuvable</h3>
            </div>
            <?php else : ?>

            <div class="panel-heading"><p class="center li-header" style="font-size:24px">  <?php echo $team->getTeamName(); ?> </p></div>
            <?php if($team->getAvatar() != ""): ?>
              <div class="panel-media" style="background-image: url('<?= WEBROOT ?><?= $team->getAvatar() ?>')">            </div>
            <?php endif; ?>
            <div class="panel-body">
                        <ul >
                            <li class="li-list"> <h3> <span class="li-list fa fa-info"> </span> Information</h3> </li>
                            <li class="li-list">
                                <span class="form-info">Description : </span>
                                <span class="form-content"><?php echo $team->getDescription(); ?></span>
                            </li>
                            <li class="li-list">
                                <span class="form-info">Date de création : </span>
                                <?php
                                  $dateCreation = $team->getDateCreated();
                                  $mois = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre"];
                                  $date = date("d ",strtotime($dateCreation)). $mois[(date("n ",strtotime($dateCreation))- 1)]. date(" Y à H:i",strtotime($dateCreation));
                                ?>
                                <span class="form-content"><?php echo $date; ?></span>
                            </li>
                            <li class="li-list">
                                <span class="form-info">Sports : </span>
                                <span class="form-content"><?php echo $team->getSports(); ?></span>
                            </li>
                        </ul>
                        <?php if(Team::imIn($team->getId())): ?>
                            <div class="pull-right" style="margin-top:-20px">
                                <a href="<?= WEBROOT; ?>team/manage/<?php echo $team->getId(); ?>" class="btn btn-primary">Gérer</a>
                            </div>
                        <?php endif; ?>
                        <?php if(!Team::imIn($idTeam)): ?>
                          <?php if($invitationsFromTeam): ?>
                            <div class="text-right">
                                <a href="#" class="btn btn-success ajax-link" data-team="<?= $idTeam; ?>" data-url="team/join">Accepter invitation</a>
                                  <a href="#" class="btn btn-danger ajax-link" data-team="<?= $idTeam; ?>" data-url="team/cancelInvitation">Rejeter invitation</a>
                            </div>
                          <?php else: ?>
                           <?php if($invitation): ?>
                               <div class="text-right">
                                   <a href="#" class="btn btn-success ajax-link" data-team="<?= $idTeam; ?>" data-url="team/cancelInvitation">Annuler demande</a>
                               </div>
                           <?php else: ?>
                               <div class="text-right">
                                  <a href="#" id="askToJoin" class="btn btn-primary poplight" rel="askToJoinHidden">Demander à rejoindre</a>
                               </div>
                           <?php endif; ?>
                         <?php endif; ?>
                       <?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="panel panel-primary">
                      <div class="panel-heading"><p class="center li-header" style="font-size:22px">Derniers events</p></div>
                      <div class="panel-body">
                        oucou
                      </div>
                    </div>
                </div>
                <div class="col-sm-4">
                  <div class="panel panel-primary">
                      <div class="panel-heading"><p class="center li-header" style="font-size:22px">Prochains events</p></div>
                      <div class="panel-body">
                        oucou
                      </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading"><p class="center li-header" style="font-size:22px"> <span class="li-list fa fa-user"> </span> Membres</p></div>
                        <div class="panel-body">
                          <div style="display:flex;flex-flow:row wrap; justify-content:space-around;">
                            <?php
                            if(count($members)<=4){
                              for($i = 0; $i < count($members);$i++){
                                $user = User::findById($members[$i]->getIdUser());

                                if($user->getAvatar() == ""){
                                  echo '<span style="display:inline-block;font-size:18px;margin-right:30px;text-align:center"><a href="'.WEBROOT.'user/show/'.$user->getId().'"><img class="avatar-profil" src='.WEBROOT.'public/img/unknowUser.png></img>';
                                }else{
                                  echo '<span style="display:inline-block;font-size:18px;margin-right:30px;text-align:center"><a href="'.WEBROOT.'user/show/'.$user->getId().'"><img class="avatar-profil" src='.WEBROOT.$user->getAvatar().'></img>';
                                }
                                echo '<br><b>'.$user->getUsername().'</b></a></span>';
                              }
                            }else{
                              echo '<div class="fourUsers">';
                                for($i = 0; $i < 4;$i++){
                                  $user = User::findById($members[$i]->getIdUser());
                                    if($user->getAvatar() == ""){
                                      echo '<span style="display:inline-block;font-size:18px;margin-right:30px;text-align:center"><a href="'.WEBROOT.'user/show/'.$user->getId().'"><img class="avatar-profil" src='.WEBROOT.'public/img/unknowUser.png></img>';
                                    }else{
                                      echo '<span style="display:inline-block;font-size:18px;margin-right:30px;text-align:center"><a href="'.WEBROOT.'user/show/'.$user->getId().'"><img class="avatar-profil" src='.WEBROOT.$user->getAvatar().'></img>';
                                    }
                                echo '<br><b>'.$user->getUsername().'</b></a></span>';
                              }
                              echo "<a href='#' id='showUsers'><span style='font-size:18px;border:2px solid #6c6599;border-radius:50%;padding:4px;color:#6c6599'>+".(count($members)-4)."</span></a>";
                              echo '</div>';
                              echo '<div class="allUsers" style="display:none">';
                              $i=0;
                              foreach($members as $member){
                                if($i%4 == 0){
                                  echo '<br>';
                                }
                                    $user = User::findById($member->getIdUser());

                                    if($user->getAvatar() == ""){
                                      echo '<span style="display:inline-block;font-size:18px;margin-right:30px;padding-bottom:15px;text-align:center"><a href="'.WEBROOT.'user/show/'.$user->getId().'"><img class="avatar-profil" src='.WEBROOT.'public/img/unknowUser.png></img>';
                                    }else{
                                      echo '<span style="display:inline-block;font-size:18px;margin-right:30px;padding-bottom:15px;text-align:center"><a href="'.WEBROOT.'user/show/'.$user->getId().'"><img class="avatar-profil" src='.WEBROOT.$user->getAvatar().'></img>';
                                    }
                                    echo '<br><b>'.$user->getUsername().'</b></a></span>';
                                $i++;
                                }
                                echo "<a href='#' id='hideAllUsers'><span class='btn btn-primary' style='position:relative,bottom:0'>Masquer</span></a>";
                                echo '</div>';
                            }
                            ?>
                          </div>
                    </div>
                </div>

            </div>
                <?php endif;?>
        </div>
    </div>
</div>
<div class="row" id="askToJoinHidden" class="popup_block">
    <div class="col-sm-12">
        <div class="panel panel-primary">
             <div class="panel-body">
                <?php
                  $this->createForm($formAskToJoin,[]);
                  /*<a href="#" class="btn btn-primary ajax-link prompt" data-team="<?= $idTeam; ?>" data-url="team/askToJoin"*/
                ?>
             </div>
        </div>
    </div>
</div>
