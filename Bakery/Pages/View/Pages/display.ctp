<?php

$this->start('title');
echo Configure::read('Admin.Menu.title');
$this->end();

//echo '<h1>'.Configure::read('Admin.Menu.title').'</h1>';

echo $Page['content'];
if(is_array(Configure::read('Admin.Menu.custom_fields')))
foreach(Configure::read('Admin.Menu.custom_fields') as $name => $value)
{
	if($name == 'googlemap')
	{
		list($lat, $lng, $zoom) = explode('|', $value);
		echo $this->element('googlemap', array('lat'=>$lat,'lng'=>$lng, 'zoom'=>$zoom));
	}
	elseif($name == 'map')
	{
		echo $value;
	}
}


$this->start('right');


echo $this->element('Admin.menu', array('parent_id' => Configure::read('Admin.Menu.id')));

$this->end();
