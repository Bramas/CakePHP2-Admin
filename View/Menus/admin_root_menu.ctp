<?php
echo $this->AdminForm->create('RootMenuOptions');

echo $this->AdminForm->input('redirectTo', array('type' => 'text', 'label' => 'Redirect to:'))

echo $this->AdminForm->end('Enregistrer');