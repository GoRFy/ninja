<div class="row vertical-center">
  <div class="col-sm-12">
    <div class="col-sm-4 col-sm-offset-2">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <?php
                $this->createForm($formLogin, $logErrors);
              ?>
              </div>
          </div>
        </div>
        <div class="panel-footer">
          <?php echo isset($this->data["error_message"]) ? $this->data["error_message"] : "" ?>
        </div>
      </div>
    </div>
    <div class="col-sm-3 ">
      <div class="panel panel-primary">
        <div clas="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <h1>Toujours pas inscrit ?</h1>
              <h3>Si vous ne possédez toujours pas de compte, <a href="<?= WEBROOT; ?>user/subscribe">inscrivez vous ici</a>.</h3>
              <hr>
              <h1>Mot de passe oublié ?</h1>
              <h3>Si vous avez oublié votre mot de passe, <a href="<?= WEBROOT; ?>user/resetPassword">récupérez le ici</a>.</h3>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
