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
			$this->Role->save($this->request->data);
			$this->redirect(array($this->Role->id));
			exit();
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

