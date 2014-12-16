<?php

class RolesController extends AdminAppController {
	function admin_delete($id)
	{
		$this->Role->delete($id);
		$this->redirect(array('action' => 'index'));
		exit();
	}
	function admin_edit($id = null)
	{
		if(!empty($this->request->data))
		{
			App::uses('Set', 'Utility');
			if(empty($this->request->data['Role']['alias']))
			{
                App::uses('Inflector', 'Utility');
				$this->request->data['Role']['alias'] = Inflector::slug($this->request->data['Role']['name'], '-');
			}
			$dataCapabilities = Set::flatten($this->request->data['RoleCapability']);
			$this->Role->save($this->request->data);
			$defaultCapabilities = $this->Role->Capability->find('list',array(
				'conditions' => array(
					'role_id' => $this->Role->id,
					'args' => null
					),
				'fields' => array('id', 'capability')
				));
			$delete = array();
			foreach($defaultCapabilities as $id => $capability)
			{
				if(empty($dataCapabilities[$capability]))
				{
					$delete[] = $id;
				}
			}
			foreach($dataCapabilities as $capability => $ok)
			{
				if($ok && !in_array($capability, array_values($defaultCapabilities)))
				{
					$this->Role->Capability->create();
					$this->Role->Capability->save(array(
						'capability' => $capability,
						'role_id' 	 => $this->Role->id
						));
				}
			}
			if(!empty($delete))
			{
				$this->Role->Capability->deleteAll(array(
					'Capability.id' => $delete
				));
			}

			$this->redirect(array($this->Role->id));
		}
		$this->request->data = $this->Role->findById($id);
	}
	function admin_index()
	{
		$this->Role->recursive = 1;
		$Roles = $this->Role->find('all');
		$this->set('Roles', $Roles);
	}
}

