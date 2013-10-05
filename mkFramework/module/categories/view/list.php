<h4>Categories</h4>
<div class="list-group">
	<?php if($this->tCategories):?>
		<?php foreach($this->tCategories as $oCategories):?>
			<a href="<?php echo _root::getLink('default::category',array('id'=>$oCategories->id))?>" class="list-group-item">
				<span class="badge"><?php echo $oCategories->post_count ?></span>
				<?php echo $oCategories->name ?> #<?php echo $oCategories->getId()?>
			</a>
		<?php endforeach;?>
	<?php endif;?>
</div>

