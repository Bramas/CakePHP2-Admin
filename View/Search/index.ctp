<?php

if(empty($results))
{
	echo __('Votre recherche n\'a retourné aucun résultat');
}
else
{

debug($results);

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
$result = array_merge(array('type'=>'Inconnu', 'abstract' => false), (array) $result);
?>
<div class="results-item">
	<div class="results-item-type">
		<?php echo $result['type']; ?>
	</div>
	<div class="results-item-title">
		<?php echo $this->Html->link($result['title'],$url); ?>
	</div>
	<div class="results-item-url">
		<?php echo $this->Html->url($url, true); ?>
	</div>
	<?php if(!empty($result['abstract'])){ ?>
	<div class="results-item-abstract">
		<?php echo $result['abstract']; ?>
	</div>
	<?php } ?>
</div>
<?php
endforeach;
}