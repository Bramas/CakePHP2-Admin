<?php
foreach(Configure::read('Admin.Menu.custom_fields') as $name => $value)
{
	echo $name.' '.$value;
}

echo $Page['content'];