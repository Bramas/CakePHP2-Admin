<?php


echo $this->AdminForm->create('Page');

echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->editor('content', array('label' => 'Contenu'));

echo $this->AdminForm->end('Enregistrer');