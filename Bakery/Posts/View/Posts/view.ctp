<?php

$this->start('title');
echo $Post['Post']['title'];
$this->end();

echo '<h1>'.$Post['Post']['title'].'</h1>';

echo '<div class="content">'.$Post['Post']['content'].'</div>';

$this->start('left');

echo $this->element('list_actus', array('limit'=>10));

$controller = 'posts';
$config = $this->requestAction('/config/get/posts');
if(!empty($config['parent_menu']))
{
	$controller = $config['parent_menu'];
}	

echo $this->Html->link('Retour aux actualités',array('slug' => $controller), array('class'=>'see-all-posts'));
$this->end();
