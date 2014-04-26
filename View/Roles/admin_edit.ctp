<?php


echo $this->element('Admin.panel_header', array(
	'title'=>'Editer un role' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Role');
echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('alias');
echo $this->AdminForm->input('name');

App::uses('Set', 'Utility');
$capabilitiesSet = Set::extract('/id',$this->request->data['Capability']);
?>
<h4>Permissions du role</h4>
<?php

foreach($Capabilities as $cap_id => $cap)
{
	echo $this->AdminForm->checkbox('Capability..capability_id', array('value' => $cap_id, 'label' => $cap, 'checked' => in_array($cap_id, $capabilitiesSet)));
}
?>
<hr>
<?php
echo $this->AdminForm->end('Enregistrer');