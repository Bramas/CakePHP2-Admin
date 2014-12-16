<?php

echo $this->AdminConfig->group('admin',array('display'=>'inline'));
echo $this->AdminConfig->input('site-title',array('type'=>'text', 'label'=>'Titre du site'));
echo $this->AdminConfig->input('site-description',array('type'=>'textarea', 'label'=>'Description du site'));
echo $this->AdminConfig->end();