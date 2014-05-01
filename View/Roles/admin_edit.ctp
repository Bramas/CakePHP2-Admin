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

if(empty($this->request->data['Capability'])){
	$capabilitiesSet = array();
} else {
	$capabilitiesSet = Set::extract('/capability',$this->request->data['Capability']);
}
?>

<h3>Permissions du role</h3>
<?php

App::uses('Admin', 'Admin.Lib');
$Capabilities = Admin::getAdminCapabilities();

foreach($Capabilities as $controller => $caps)
{
	echo '<fieldset><legend>'.$controller.'</legend>';
	foreach($caps as $alias => $name)
	{
		echo $this->AdminForm->checkbox('RoleCapability.'.strtolower($alias), array( 'label' => $name, 'checked' => in_array(strtolower($alias), $capabilitiesSet)));
	}
	echo '</fieldset>';
}
?>
<hr>
<?php
debug($this->request->data);
echo $this->AdminForm->end('Enregistrer');