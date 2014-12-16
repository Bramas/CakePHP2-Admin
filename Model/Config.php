<?php

class Config extends AppModel {
	public $useTable = 'config';

	public function findGroup($group){
		$group = $this->find('all', array(
				'conditions' => array('group'=>$group)));
		$list = array();
		foreach($group as $g)
		{
			$list[$g['Config']['name']] = $g['Config']['value'];
		}
		return $list;
	}
}