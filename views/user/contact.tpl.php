<div class="row vertical-center2">
  <div class="col-sm-12">
    <div class="col-sm-5 col-sm-offset-2">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <?php
                $this->createForm($formContact, $contactError);
              ?>
              </div>
          </div>
        </div>
        <div class="panel-footer">

          <?php //echo isset($this->data["error"]) ? $this->data["error"] : "" ?>

          <?php //echo isset($this->data["success"]) ? $this->data["success"] : "" ?>

        </div>
      </div>
    </div>
    <div class="col-sm-3 ">
      <div class="panel panel-primary">
        <div clas="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <h1>Vous voulez nous contacter ?</h1>
              <h3>Si jamais vous rencontrez un problème ou vous voulez nous faire part de vos suggestions, n'hésitez pas!</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
