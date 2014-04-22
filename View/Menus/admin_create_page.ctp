<?php

foreach($Views as $view):
	$url = array(
		$id,
		$view['controller'],
		$view['action']
		);
?>
<a href="<?php echo $this->Html->url($url) ?>">
<div class="">
<?php echo $view['label']; ?>
</div>
</a>
<?php endforeach;