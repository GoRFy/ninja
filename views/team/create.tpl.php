<div class="row vertical-center">
  <div class="col-sm-12">
    <div class="col-sm-5 col-sm-offset-2">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <?php
                $this->createForm($formCreateTeam,$creaErrors);
              ?>
              </div>
          </div>
        </div>
        <div class="panel-footer">
          <?php echo isset($this->data["success"]) ? $this->data["success"] : "" ?>
        </div>
      </div>
    </div>
    <div class="col-sm-3 ">
      <div class="panel panel-primary">
        <div clas="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <h1>Comment ça se passe ?</h1>
              <h3>Votre nom d'équipe doit faire entre 3 et 12 caractères. Ne pas contenir d'insulte et réspecter la charte vidéo ludique pas mise en place mais chut mdr ^^'.</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
