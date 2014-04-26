<?php



echo $this->element('Admin.panel_header', array(
	'title'=>'Utilisateurs' , 
	'addNew' => array(
		'label' => 'Nouvel Utilisateur',
		'url' => array('action' => 'edit')
		)));


$columns = array(
	'id' => '#', 
	'username' => array('header' => 'Login', 'action' => 'edit')
	);
$actions = array(
	'edit' => array(
		'label' => 'Editer',
		'url' => array('action' => 'edit'),
		'options' => array('class' => '')
		),
	'separator' => ' | ',
	'delete' => array(
		'label' => 'Supprimer',
		'url' => array('action' => 'delete'),
		'options' => array('class' => '')
		),
	);

echo $this->element('Admin.table', array('actions'=>$actions , 'columns' => $columns, 'data' => $Users, 'model' => 'User'));
