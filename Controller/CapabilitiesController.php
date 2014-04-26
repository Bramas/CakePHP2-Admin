<?php

class CapabilitiesController extends AdminAppController {
	function admin_delete($id)
	{
		$this->Capability->delete($id);
		$this->redirect(array('action' => 'index'));
		exit();
	}
	function admin_edit($id = null)
	{
		if(!empty($this->request->data))
		{
			$this->Capability->save($this->request->data);
			$this->redirect(array($this->Capability->id));
			exit();
		}
		$this->request->data = $this->Capability->findById($id);
	}
	function admin_index()
	{
		$this->Capability->recursive = 1;
		$Capabilities = $this->Capability->find('all');
		$this->set('Capabilities', $Capabilities);
	}
}