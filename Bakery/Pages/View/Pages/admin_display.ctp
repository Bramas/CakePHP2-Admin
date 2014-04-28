<?php

echo $this->AdminForm->create('Page');

echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('parent_id', array('type' => 'hidden'));
echo $this->AdminForm->editor('content', array('label' => 'Contenu'));


if(Admin::hasCapability('pages.publish'))
{
	echo $this->AdminForm->submit('Publier');
}
else
{
	echo $this->AdminForm->submit('Soumettre à Validation');
}
