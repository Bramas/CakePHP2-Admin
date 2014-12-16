<?php


echo $this->element('Admin.panel_header', array(
	'title'=>'Editer un rôle' , 
	'backUrl' => array('action' => 'index')
		));


echo $this->AdminForm->create('Role');
echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('name');
?>

<div class="form-group menu-advance-options-show">
	<a href="#"><span>+</span> Options avancées</a>
	<script type="text/javascript">
	jQuery(function($){
		$('.menu-advance-options-show a').on('click',function(e){
			e.preventDefault();
			if($(this).find('span').html() == '+')
			{
				$('.menu-advance-options').slideDown();
				$(this).find('span').html('-');
			}
			else
			{
				$('.menu-advance-options').slideUp();
				$(this).find('span').html('+');
			}
		});
		$('.menu-advance-options').slideUp(0);
	})
	</script>
</div>
<div class="menu-advance-options">
<?php 
echo $this->AdminForm->input('alias');
 ?>
</div>

<?php

App::uses('Set', 'Utility');

if(empty($this->request->data['Capability'])){
	$capabilitiesSet = array();
} else {
	$capabilitiesSet = Set::extract('/capability',$this->request->data['Capability']);
}
?>

<h3>Permissions du rôle</h3>
<?php

App::uses('Admin', 'Admin.Lib');
$Capabilities = Admin::getAdminCapabilities();
$disabled = false;
if($this->request->data['Role']['alias'] == 'administrator')
{
	$disabled = true;
	$capabilitiesSet = array();
	foreach($Capabilities as $c)
	{
		foreach($c as $key => $n)
		{
			$capabilitiesSet[] = strtolower($key);
		}
	}
}


foreach($Capabilities as $controller => $caps)
{
	echo '<fieldset><legend>'.$controller.'</legend>';
	foreach($caps as $alias => $name)
	{
		echo $this->AdminForm->checkbox('RoleCapability.'.strtolower($alias), array( 'label' => $name, 'disabled' => $disabled,  'checked' => in_array(strtolower($alias), $capabilitiesSet)));
	}
	echo '</fieldset>';
}
?>
<hr>
<?php

echo $this->AdminForm->end('Enregistrer');