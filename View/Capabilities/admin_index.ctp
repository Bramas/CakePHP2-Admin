<?php

echo $this->element('Admin.panel_header', array(
	'title'=>'Permissions' , 
	'addNew' => array(
		'label' => 'Nouvelle Permission',
		'url' => array('action' => 'edit')
		)));


$columns = array(
	'id' => '#', 
	'name' => array('header' => 'Nom', 'action' => 'edit')
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

echo $this->element('Admin.table', array('actions'=>$actions , 'columns' => $columns, 'data' => $Capabilities, 'model' => 'Capability'));
