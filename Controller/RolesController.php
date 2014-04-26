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
			//remove the empty row (coming from checkboxes)
			foreach($this->request->data['Capability'] as $i => $d)
			{
				if(empty($d['capability_id']))
				{
					unset($this->request->data['Capability'][$i]);
				}
			}
			
			$this->Role->save($this->request->data);
			$this->redirect(array($this->Role->id));
		}
		$this->request->data = $this->Role->findById($id);

		$Capabilities = $this->Role->Capability->find('list');
		$this->set('Capabilities', $Capabilities);
	}
	function admin_index()
	{
		$this->Role->recursive = 1;
		$Roles = $this->Role->find('all');
		$this->set('Roles', $Roles);
	}
}

