<?php

if(empty($results))
{
	echo __('Votre recherche n\'a retourné aucun résultat');
}
else
{


foreach($results as $result):
?>
<div class="results-item">
	<?php echo $this->Html->link($result['title'],$result['url']); ?>
</div>
<?php
endforeach;
}