<div class="page-header">
	<h1><?php echo $this->oPosts->name ?></h1>
	<p><small>
	Category : <a href="<?php echo _root::getLink('default::category',array('id'=>$this->oPosts->category_id))?>"><?php if(isset($this->tJoinmodel_categories[$this->oPosts->category_id])) echo $this->tJoinmodel_categories[$this->oPosts->category_id]?></a>,
	by <a href="index.html"><?php if(isset($this->tJoinmodel_users[$this->oPosts->user_id])) echo $this->tJoinmodel_users[$this->oPosts->user_id]?></a> on <em><?php $oDate=new plugin_datetime($this->oPosts->created); echo $oDate->toString('D dS Y'); ?></em>
	</small></p>
</div>

<article>
	<?php echo plugin_markdown::tr($this->oPosts->content) ?>
</article>

<hr>

<section class="comments">
	
<?php echo $this->oCommentsAdd->show()?>

<?php echo $this->oComments->show()?>

</section>
