<?php
	if(!User::isAdmin()){
		if(count($captain) > 0){
				if(!($captain[0]->getCaptain() > 0)){
					header('Location:'.WEBROOT.'user/login');
				}
		}else{
			header('Location:'.WEBROOT.'user/login');
		}
	}
?>

<div class="row">
    <div class="col-sm-6">
        <div class="panel">
            <div class="panel-body">
                <?php
                    $this->createForm($formEdit, $editErrors);
                ?>
                <?php if($team->getAvatar() != ""): ?>
                    <img src="<?= "../../".$team->getAvatar(); ?>" style="width:80px;height:80px">
                <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?php echo isset($this->data["success"]) ? $this->data["success"] : "" ?>
<?php echo isset($this->data["movingFile"]) ? $this->data["movingFile"] : "" ?>
