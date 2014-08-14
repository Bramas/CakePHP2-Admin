<?php

App::uses('Admin', 'Admin.Lib');
App::uses('AdminAppController', 'Admin.Controller');

class ConfigController extends AdminAppController {

	public $uses = 'Admin.Config';

	public function admin_get($group)
	{
		return $this->Config->findGroup($group);
	}
	public function admin_save()
	{
		if(empty($this->request->data['Config']))
		{
			exit('{"success":0,"message":"error"}');
		}
		$group = $this->request->data['Config']['_group'];
		foreach($this->request->data['Config'] as $name => $value)
		{
			if($name == '_group')
			{
				continue;
			}
			$conditions = array(
				'group' => $group,
				'name' => $name
				);
			$e = $this->Config->find('first', array(
				'conditions' => $conditions));
			if(empty($e))
			{
				$conditions['id'] = null;
				$this->Config->create();
			}else
			{
				$conditions['id'] = $e['Config']['id'];
			}
			$conditions['value'] = $value;
			$this->Config->save(array('Config' => $conditions));
		}
		//
		exit('{"success":1}');
	}

}