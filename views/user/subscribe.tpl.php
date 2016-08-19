<div class="row vertical-center">
  <div class="col-sm-12">
    <div class="col-sm-4 col-sm-offset-2">
      <div class="panel panel-primary">
        <div class="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <?php
                $this->createForm($formSubscribe, $subErrors);
              ?>
              </div>
          </div>
        </div>
        <div class="panel-footer">
          <?php echo isset($this->data["mailerMessage"])?$this->data["mailerMessage"]:"" ?>
        </div>
      </div>
    </div>
    <div class="col-sm-3 ">
      <div class="panel panel-primary">
        <div clas="panel-body">
          <div class="row">
            <div class="col-sm-12">
              <h1>Déjà inscrit ?</h1>
              <h3>Si vous possédez déjà un compte, <a href="<?= WEBROOT; ?>user/login">connectez vous ici</a>.</h3>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
