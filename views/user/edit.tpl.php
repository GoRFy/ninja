<?php
    //$user = $this->data["user"];
    if(!User::itsMy($idUser)){
        header("location: ".WEBROOT."index");
    }
?>
<div class="row">
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-heading"><h3 class="upper center">Editez votre profil</h3></div>
            <div class="panel-body">

            <?php if($user->getAvatar() != ""): ?>
               <img class="avatar" src="<?= "../../".$user->getAvatar(); ?>" style="width:100px;height:100px">
               <a href="#" class="ajax-link" data-url="user/deleteAvatar">Supprimer mon avatar</a>
            <?php endif;?>

                <?php

                      //VERIFIER SI LE PROFIL EST COMPLET, SI OUI ON PEUX RAJOUTER UN AVATAR,
                      // SINON ON MET UN TEXte : 3VEUILLEZ REMPLIR VOTRE PROFIL

                    $this->createForm($formEdit, $editErrors);

                ?>
            </div>
        </div>
    </div>
</div>

<?php echo isset($this->data["success"]) ? $this->data["success"] : "" ?>
<?php echo isset($this->data["movingFile"]) ? $this->data["movingFile"] : "" ?>
