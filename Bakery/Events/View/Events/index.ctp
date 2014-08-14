<?php 
$controller = '/events';
$config = $this->requestAction('/admin/config/get/events');
if(!empty($config['parent_menu']))
{
	$controller = $config['parent_menu'];
}
foreach($Events as $e)
{
	echo $this->Html->link($e['Event']['title'], $controller.'/view/'.$e['Event']['id']);
}