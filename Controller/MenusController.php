<?php

App::uses('Admin', 'Admin.Lib');

class MenusController extends AdminAppController {


	var $helpers = array('Admin.AdminForm');
    var $uses = array('Admin.Menu');

    public function admin_edit($id) {
        $menu = $this->Menu->findById($id);
        if(empty($menu['Menu']['controller']))
        {
			$this->redirect(array('action' => 'create_page', $id));
			exit();
        }
        $url = array(
        	'controller' => $menu['Menu']['controller'],
        	'action' => $menu['Menu']['action'],
        	'admin' => true,
        	'plugin' => false,
        	$menu['Menu']['args']
        	);

       	$this->set('id', $id);
       	$this->set('controller', $menu['Menu']['controller']);
       	$this->set('save_action', $menu['Menu']['action']);
        $this->request->data = $menu;

        $this->set('url', $url);
    }

    public function admin_move()
    {
    	if(empty($this->request->data))
    	{
    		exit('{"error":true}');
    	}
    	if($this->request->data['old_parent_id'] != $this->request->data['Menu']['parent_id'])
    	{
	    	$this->Menu->save($this->request->data);
	    }

		$children = $this->Menu->children($this->request->data['Menu']['parent_id'], true, 'id', 'Menu.lft ASC');

    	$position = 0;
    	foreach($children as $child)
    	{
    		if($child['Menu']['id'] == $this->request->data['Menu']['id'])
    		{
    			break;
    		}
    		$position++;
    	}
	
    	$newPosition = $this->request->data['position'];
    	$delta = $newPosition - $position;
    	$out = '';
    	if($delta > 0)
    	{
    		$this->Menu->moveDown($this->request->data['Menu']['id'], $delta);
    		$out .= ', "moveDown":'.$delta;
    	}
    	elseif($delta < 0)
    	{
    		$delta = -$delta;
    		$this->Menu->moveUp($this->request->data['Menu']['id'], $delta);
    		$out .= ', "moveUp":'.$delta;
    	}

    	exit('{"success":true'.$out.'}');
    }


    public function admin_delete($id) {

    	$this->request->data = $this->Menu->findById($id);
    	if(empty($this->request->data))
    	{
    		exit('{"error":true, "message":"menu item does not exists"}');
    	}

    	$action = 'admin_'.$this->request->data['Menu']['action'].'_delete';
    	$controllerClassName = ucfirst($this->request->data['Menu']['controller']).'Controller';
		App::uses($controllerClassName, 'Controller');
    	$methodExists = method_exists($controllerClassName, $action);
        if($methodExists)
        {
        	$url = array(
	        	'controller' => $this->request->data['Menu']['controller'],
	        	'action' => $this->request->data['Menu']['action'].'_delete',
	        	'admin' => true,
	        	'plugin' => false,
	        	$this->request->data['Menu']['args']
	    	);
    		$ok = $this->requestAction($url);
    	}
    	else
    	{
    		$ok = true;
    	}
    	if($ok !== false)
    	{
		    if($this->Menu->delete($id))
		    {
				exit('{"success":1,"error":0}');
        	}
        	else
        	{
				exit('{"error":1, "message":"error while deleting menu item"}');
        	}
        }
        else
        {
        	exit('{"error":1, "message":"error while deleting associated page"}');
        }
		exit('{"error":1, "message":"unknown error"}');
    }
    public function admin_save($id, $controller, $action) {
    	if(empty($this->request->data))
    	{
    		$this->redirect('/');
    		exit();
    	}

        $url = array(
        	'controller' => $controller,
        	'action' => $action,
        	'admin' => true,
        	'plugin' => false
        	
    	);
    	$args = $this->requestAction($url, array('data'=> $this->request->data));
    	if($args !== false)
    	{
        	$this->request->data['Menu']['args'] = $args;
		    if($this->Menu->save($this->request->data))
		    {
        		$this->Session->setFlash(__('Sauvegardé avec succés'), 'Admin.flash_success');
        	}
        	else
        	{
        		$this->Session->setFlash(__('Erreur pendant la sauvegarde.'), 'Admin.flash_error');
        	}
        }
        else
        {
        	$this->Session->setFlash(__('Erreur pendant la sauvegarde.'), 'Admin.flash_error');
        }

    	$this->redirect(array('action' =>'edit', $id));
    }
	public function admin_menu_edit($id) {
		$this->layout = 'Admin.admin_panel';
		$this->request->data = $this->Menu->findById($id);
	}

	public function admin_create_menu($parent_id)
	{
		$this->request->data = array(
			'Menu'=>array(
				'parent_id' => $parent_id,
				'title' 	=> __('Nouvelle Page')
				)
			);
	    $this->Menu->save($this->request->data);
	    $this->redirect(array('action' => 'create_page', $this->Menu->id));
	    exit();
	}
	public function admin_create_page($id, $controller = null, $action=null)
	{
		if(!empty($action)){

			$data = array('id'=>$id, 'controller' => $controller, 'action' => $action);
			$this->Menu->save(array('Menu' => $data));
			$this->redirect(array('action' => 'edit', $id));
			exit();
		}
		$this->request->data = $this->Menu->findById($id);
		if(empty($this->request->data))
		{
			$this->redirect('/');
			exit();
		}
		
		$Views = Admin::getViews();
		$this->set('id', $id);
		$this->set('Views', $Views);
	}

    public function admin_all() {
        //$d = array('Menu'=>array('parent'))
        return $this->Menu->find('threaded');
    }

}
