<?php


echo $this->element('Admin.panel_header', array(
	'title'=>'Editer un role' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Role');
echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('alias');
echo $this->AdminForm->input('name');
echo $this->AdminForm->end('Enregistrer');