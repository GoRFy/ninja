<div class="row vertical-center">
  <div class="col-sm-12">
    <div class="col-sm-4 col-sm-offset-2">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <?php
                  $this->createForm($form, $formErrors);
              ?>
              </div>
          </div>
        </div>
        <div class="panel-footer">
          <?php echo isset($this->data["mail_new_pwd"])?$this->data["mail_new_pwd"]:"" ?>
        </div>
      </div>
    </div>
    <div class="col-sm-3 ">
      <div class="panel panel-primary">
        <div clas="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <h1>Comment ça se passe ?</h1>
              <h3>Rentrez l'email lié au compte dont vous avez oublié le mot de passe, nous vous enverrons un mail pour en générer un nouveau.</a></h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
