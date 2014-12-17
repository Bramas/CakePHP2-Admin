<?php

class MediaController extends AdminAppController {
    
	public $uses = array('Media.Media');
    
	public function admin_index() {
        $this->set('Medias', $this->Media->find('all'));
	}

}