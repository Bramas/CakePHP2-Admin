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
	foreach($params['custom_fields'] as $name => $type)
	{
/*
		if(is_array($custom_field))
		{
			$type = empty($custom_field['type'])?'text':$custom_field['type'];
		}
		else
		{
			$type = $name = $custom_field;
		}*/
		if(!is_array($type))
		{
			$type = array('type' => $type);
		}
		$type = array_merge(array('type' => $type['type'], 'label' => $type['type']), $type);
		echo $this->element('custom_fields/'.$type['type'], array('name' => $name, 'label'=>$type['label']));
	}
}

echo $menu_item_content;

echo $this->AdminForm->end();