<?php
echo $this->AdminForm->create('RootMenuOptions');

echo $this->AdminForm->input('redirectTo', array('type' => 'text', 'label' => 'Rediriger vers:'));

echo $this->AdminForm->end('Enregistrer');