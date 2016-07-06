<?php
    $team = $this->data["team"];
?>

<div class="row">
    <div class="col-sm-6">
        <div class="panel panel-primary">
            <?php if($team == null):?>
            <div class="panel-body">
                <h3>Team not found</h3>
            </div>
            <?php else : ?>
            <div class="panel-media">
                <?php if($team->getAvatar() != ""): ?>
                    <img src="<?= "../../".$team->getAvatar(); ?>" style="width:80px;height:80px">
                <?php endif;?>
            </div>
            <div class="panel-heading"><h3><?php echo $team->getTeamName(); ?></h3></div>
            <div class="panel-body">
                <ul>
                  <?php if(!$team->getDescription() == ""): ?>
                    <li>
                        <?php echo $team->getDescription(); ?>
                    </li>
                  <?php endif; ?>
                    <li>
                        <span class="fa fa-user"></span>
                        <?php
                        if(is_array($members)){
                          foreach($members as $member){
                              $user = User::findById($member->getIdUser());
                              echo $user->getUsername()."<br>";
                          }
                        }else{
                          $user = User::findById($members->getIdUser());
                          echo $user->getUsername()."<br>";
                        }
                        ?>
                    </li>
                    <!--
                        AFFICHER DERNIER EVENT ?
                        EVENT RECURRENT ?
                    -->
                </ul>
                <?php if(Team::imIn($team->getId())): ?>
                    <div class="text-right">
                        <a href="<?= WEBROOT; ?>team/manage/<?php echo $team->getId(); ?>" class="btn btn-primary">Manage</a>
                    </div>
                <?php endif; ?>
                <?php if(!Team::imIn($idTeam)): ?>
                   <?php if($invitation): ?>
                       <div class="text-right">
                           <span class="btn btn-success ajax-link" data-team="<?= $idTeam; ?>" data-url="team/cancelInvitation">Cancel asking</a>
                       </div>
                   <?php else: ?>
                       <div class="text-right">
                           <a href="#" class="btn btn-primary ajax-link prompt" data-team="<?= $idTeam; ?>" data-url="team/askToJoin" >Ask to join</a>
                       </div>
                   <?php endif; ?>
               <?php endif; ?>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>
