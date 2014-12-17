<?php



echo $this->element('Admin.panel_header', array(
	'title'=>'Agenda' , 
	'addNew' => array(
		'label' => 'Nouvel Evènement',
		'url' => array('action' => 'edit')
		),
	'after' => $this->AdminConfig->modalButton('events','btn btn-default btn-sm')));


$columns = array(
	'id' => '#', 
	'title' => array('header' => 'Titre', 'action' => 'edit')
	);
$actions = array(
	'edit' => array(
		'label' => 'Editer',
		'url' => array('action' => 'edit'),
		'options' => array('class' => ''),
		'require' => array('events.edit', 'id')
		),
	'separator' => ' | ',
	'delete' => array(
		'label' => 'Corbeille',
		'url' => array('action' => 'delete'),
		'options' => array('class' => ''),
		'require' => array('events.delete', 'id')
		),
	);
	
	
echo $this->AdminConfig->group('events');
echo $this->AdminConfig->input('parent_menu', array('type'=>'menu', 'label'=>'Menu parent'));
echo $this->AdminConfig->end();

echo $this->element('Admin.table', array('actions'=>$actions , 'columns' => $columns, 'data' => $Events, 'model' => 'Event'));
