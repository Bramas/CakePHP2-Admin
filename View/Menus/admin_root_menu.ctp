<?php
echo $this->AdminForm->create('RootMenuOptions');

$id = (empty($this->request->data['Menu']) ? '0' : $this->request->data['Menu']['id']);
$list = $this->requestAction('menus/getList/'.$id.'/2');
if(empty($list))
{
	$list = array(''=>'');
}else
{
	$ar = $list[0]['children'];
	$ar = Set::combine($ar, '{n}.Menu.slug', '{n}.Menu.title');
	$list = array();
	foreach($ar as $e => $v)
	{
		$list['/'.$e] = $v;
	}
}

echo $this->AdminForm->input('redirectTo', array('type' => 'select', 'label' => 'Rediriger vers:', 'options' => $list));

echo $this->AdminForm->end('Enregistrer');