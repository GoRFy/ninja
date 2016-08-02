 <?php
 //Se l'utilisateur y accede par URL, mais n'a pas les droit on le redirige
     if(count($captain) > 0){
       if(!($captain[0]->getCaptain() > 0)){
         header('Location:'.WEBROOT.'user/login');
       }
     }else{
       header('Location:'.WEBROOT.'user/login');
     }
     $adresse = "http://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
     $adresse =explode("/",$adresse);
     $id = $adresse[count($adresse)-1];
?>

<div class="row vertical-center">
  <div class="col-sm-12">
    <div class="col-sm-5 col-sm-offset-2">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <?php
                 $this->createForm($formInviteTeam,$inviteErrors);
             ?>
              </div>
          </div>
        </div>
        <div class="panel-footer">
          <?php echo isset($this->data["error"]) ? $this->data["error"] : "" ?>

          <?php echo isset($this->data["success"]) ? $this->data["success"] : "" ?>
        </div>
      </div>
    </div>
    <div class="col-sm-3 ">
      <div class="panel panel-primary">
        <div clas="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <h1>Retourner à la page de team ?</h1>
              <h3><a href="<?= WEBROOT; ?>team/manage/<?=$id?>">Cliquez ici</a>.</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
