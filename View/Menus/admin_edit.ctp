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

echo $menu_item_content;



echo $this->AdminForm->end();