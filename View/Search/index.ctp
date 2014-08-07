<?php

if(empty($results))
{
	echo __('Votre recherche n\'a retourné aucun résultat');
}
else
{


foreach($results as $result):

	$url = $result['url'];
if(empty($url['admin']))
{
	$url['admin'] = false;
}
if(empty($url['plugin']))
{
	$url['plugin'] = false;
}
?>
<div class="results-item">
	<?php echo $this->Html->link($result['title'],$url); echo $result['score']; ?>
</div>
<?php
endforeach;
}