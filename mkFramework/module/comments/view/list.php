

	

	<h3><?php echo count($this->tComments)?> Commentaire(s)</h3>

	<?php if($this->tComments):?>
	<?php foreach($this->tComments as $oComments):?>
	<div class="row">
		<div class="col-md-2">
			<img src="<?php echo plugin_gravatar::get($oComments->mail)?>" width="100%">
		</div>
		<div class="col-md-10">
			<p><strong><?php echo $oComments->username ?></strong> <?php echo $oComments->created ?></p>
			<p><?php echo $oComments->content ?></p>
		</div>
	</div>
	<?php endforeach;?>
	<?php endif;?>
	
	


