<?php


echo $this->element('Admin.panel_header', array(
	'title'=>'Editer une permission' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Capability');
echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('alias');
echo $this->AdminForm->input('name');
echo $this->AdminForm->input('plugin');
echo $this->AdminForm->input('controller');
echo $this->AdminForm->input('view');
echo $this->AdminForm->input('args');
echo $this->AdminForm->end('Enregistrer');