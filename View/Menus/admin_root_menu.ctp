<?php
echo $this->AdminForm->create('RootMenuOptions');

$list = $this->requestAction('menus/getGeneratedTreeList');
if(empty($list))
{
	$list = array(''=>'');
}else
{
	$ar = array();
	foreach($list as $e => $v)
	{
		$ar['/'.$e] = $v;
	}
	$list = $ar;
}

echo $this->AdminForm->input('redirectTo', array('type' => 'select', 'label' => 'Rediriger vers:', 'options' => $list));

echo $this->AdminForm->end('Enregistrer');