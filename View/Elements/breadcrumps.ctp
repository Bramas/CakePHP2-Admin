<?php
$mArray = array();
if(is_array(Configure::read('Admin.MenuPath')))
foreach(Configure::read('Admin.MenuPath') as $menu)
{
	if($menu['Menu']['parent_id'])
	{
		$mArray[] = $menu['Menu']['title'];
	}
}
if($this->fetch('title') != $menu['Menu']['title'])
{
	$mArray[] = $this->fetch('title');
}
echo implode($mArray, ' > ');