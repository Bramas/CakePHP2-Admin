<?php
if(Configure::read('Admin.searchTitle'))
{
	$this->start('title');
		echo Configure::read('Admin.searchTitle');
	$this->end();
}
if(empty($results))
{
	echo __('Votre recherche n\'a retourné aucun résultat');
}
else
{


if(!function_exists('texte_resume_brut'))
{
	function texte_resume_brut($texte, $nbreCar)
	{
		$texte 				= trim(strip_tags($texte));
		if(is_numeric($nbreCar))
		{
			$PointSuspension	= '...';
			$texte			.= ' ';
			$LongueurAvant		= strlen($texte);
			if ($LongueurAvant > $nbreCar) {
				$texte = substr($texte, 0, strpos($texte, ' ', $nbreCar));
				if ($PointSuspension!='') {
					$texte	.= $PointSuspension;
				}
			}
		}
		return $texte;
	};
}


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
		<?php echo texte_resume_brut($result['abstract'], 200); ?>
	</div>
	<?php } ?>
</div>
<?php
endforeach;
}