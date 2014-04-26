<?php 

echo $this->element('Admin.panel_header', array(
	'title'=>'Editer une actualité' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Post');

echo $this->AdminForm->input('id', array('type'=>'hidden'));
echo $this->AdminForm->input('title', array('type' => 'text'));
echo $this->AdminForm->editor('content', array('label' => 'Contenu'));

echo $this->AdminForm->submit('Enregistrer');
echo $this->AdminForm->end();