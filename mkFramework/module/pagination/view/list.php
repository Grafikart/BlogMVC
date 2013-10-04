<?php $tParam=$this->tParam?>
<ul class="pagination">
	<?php $tParam[$this->sParamPage]=$this->previousPage?>
	<li><a href="<?php echo _root::getLink($this->sModuleAction,$tParam) ?>">&laquo;</a></li>
	<?php for($i=1;$i<=$this->iMax;$i++):?>
		<?php $tParam[$this->sParamPage]=$i?>
		<li <?php if($i==($this->iPage+1)):?>class="active"<?php endif;?>><a href="<?php echo _root::getLink($this->sModuleAction,$tParam) ?>"><?php echo $i?></a></li> 
	<?php endfor;?>
	<?php $tParam[$this->sParamPage]=$this->nextPage+1?>
	 <li><a href="<?php echo _root::getLink($this->sModuleAction,$tParam) ?>">&raquo;</a></li>
</ul>

