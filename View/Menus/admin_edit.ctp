<?php

echo $this->AdminForm->create('Menu', array('url' => array('action' => 'save', $id, $controller, $save_action)));
echo $this->AdminForm->input('id', array('type' => 'hidden'));
echo $this->AdminForm->input('title', array('type' => 'text'));

echo $this->requestAction($url, array('return', 'named' => array('admin_panel' => 1)));


echo $this->AdminForm->submit('Enregistrer');
echo $this->AdminForm->end();