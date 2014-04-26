<?php

echo $this->AdminForm->create('PostOptions');

echo $this->AdminForm->input('count', array('label' => 'Nombre d\'actualité par page'));
echo $this->AdminForm->input('type', array('label' => 'type d\'affichage', 'type'=>'select','options' => array('blog' => 'Blog', 'list' => 'Liste')));

echo $this->AdminForm->end('Enregistrer');
