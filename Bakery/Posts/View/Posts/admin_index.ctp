<?php



echo $this->element('Admin.panel_header', array(
	'title'=>'Actualités' , 
	'addNew' => array(
		'label' => 'Nouvelle Actualité',
		'url' => array('action' => 'edit')
		)));


$columns = array(
	'id' => '#', 
	'title' => array('header' => 'Titre', 'action' => 'edit')
	);
$actions = array(
	'edit' => array(
		'label' => 'Editer',
		'url' => array('action' => 'edit'),
		'options' => array('class' => ''),
		'require' => array('posts.edit', 'id')
		),
	'separator' => ' | ',
	'delete' => array(
		'label' => 'Corbeille',
		'url' => array('action' => 'delete'),
		'options' => array('class' => ''),
		'require' => array('posts.delete', 'id')
		),
	);

echo $this->element('Admin.table', array('actions'=>$actions , 'columns' => $columns, 'data' => $Posts, 'model' => 'Post'));
