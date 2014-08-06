<?php

/*
echo $this->element('Admin.panel_header', array(
	'title'=>'Menu'
		));
*/

$disabled = !Admin::hasCapability('admin.menus.edit');

echo $this->AdminForm->create('Menu', array('url' => array('action' => 'save')));
if($menu_item_panel_header)
{
	echo $this->element('Admin.panel_header', $menu_item_panel_header);
}

echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('title', array(
	'type' => 'text', 
	'id'=>'menuTitleInput', 
	'label' => 'Titre',
	'disabled' => $disabled));
?>
<div class="form-group">
	<div class="input-group input-group-sm">
		<span class="input-group-addon"><?php echo $this->Html->url('/',true); ?></span>
		
<?php echo $this->AdminForm->input('slug', array('data-admin-toggle' => 'slug' ,'data-admin-slug-id' => 'menuTitleInput', 'after' => false, 'before'=>false,'type' => 'text', 'label' => false,
	'disabled' => $disabled)); ?>
	</div>
</div>
<?php


echo $this->AdminForm->input('params', array(
'type' => (Admin::isAdministrator()?'text':'hidden'), 
'label' => 'Paramètre'));



$params = json_decode($this->request->data['Menu']['params'], true);
if(!empty($params['custom_fields']) && is_array($params['custom_fields']))
{
	foreach($params['custom_fields'] as $custom_field)
	{
		echo $this->element('custom_fields/'.$custom_field, array('name' => $custom_field));
	}
}

echo $menu_item_content;

echo $this->AdminForm->end();