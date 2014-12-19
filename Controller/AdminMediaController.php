<?php

App::uses('Admin', 'Admin.Lib');
App::uses('AdminAppController', 'Admin.Controller');

class AdminMediaController extends AdminAppController {
    
	public $uses = array('Media.Media');
    
	public function admin_index() {
        $this->set('Medias', $this->Media->find('all'));
	}

}