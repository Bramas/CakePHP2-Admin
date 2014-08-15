<?php 

echo $this->element('Admin.panel_header', array(
	'title'=>'Editer un événement' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Event');

echo $this->AdminForm->input('id', array('type'=>'hidden'));
echo $this->AdminForm->input('title', array('type' => 'text'));
echo '<div class="form-group">De '.$this->AdminForm->date('begin', array('default'=>true,'label' => 'Début'));
echo ' à '.$this->AdminForm->date('end', array('default'=>true,'label' => 'Fin')).' (format jj/mm/aaaa)</div>';
echo $this->AdminForm->editor('content', array('label' => 'Contenu'));


echo $this->AdminForm->submit('Enregistrer');
echo $this->AdminForm->end();