<?php

App::uses('Admin', 'Admin.Lib');
App::uses('AdminAppController', 'Admin.Controller');

class MenusController extends AdminAppController {


	var $helpers = array('Admin.AdminForm');
    var $uses = array('Admin.Menu');


    public $adminViews = array(
                    'root_menu' => array(
                        'title' => 'Contient d\'autres liens'
                    ));

    public function admin_edit($id) {
        $menu = $this->Menu->findById($id);
        if(empty($menu['Menu']['controller']))
        {
			$this->redirect(array('action' => 'create_page', $id));
			exit();
        }

        
        $view = Admin::getAdminView($menu);
        $url = $view['edit']['url'];
       	$this->set('id', $id);
        $this->request->data = $menu;

        $menu_item_content = '';
        if($view['edit']['exists'])
        {
            $menu_item_content = $this->requestAction($url, array('return', 'named' => array('admin_panel' => 1)));
        }
        $this->set('menu_item_content', $menu_item_content);
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

    	
        $view = Admin::getAdminView($this->request->data);
        $url = $view['delete']['url'];

        if($view['delete']['exists'])
        {
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
    public function admin_save() {
    	if(empty($this->request->data))
    	{
    		$this->redirect('/');
    		exit();
    	}
        $id = $this->request->data['Menu']['id'];
        $view = Admin::getAdminView($this->Menu->findById($id));
        $url = $view['save']['url'];
        if($view['save']['exists'])
        {
    	   $args = $this->requestAction($url, array('data'=> $this->request->data));
        }
        else
        {
            $args = '';
        }
    	if($args !== false)
    	{
            if(empty($this->request->data['Menu']['slug']))
            {
                $this->request->data['Menu']['slug'] = $this->request->data['Menu']['title'];
            }
            App::uses('Inflector', 'Utility');
            $this->request->data['Menu']['slug'] = Inflector::slug($this->request->data['Menu']['slug'], '-');
            
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
	public function admin_root_menu($id=null) {
        if(!empty($this->request->data))
        {
            return $this->request->data['Menu']['id'];
        }
		$this->layout = 'Admin.admin_panel';
		$this->request->data = $this->Menu->findById($id);
	}
    public function root_menu($id = null)
    {
        $menu = $this->Menu->children(Configure::read('Admin.Menu.id'));
        exit(debug($menu));
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
	public function admin_create_page($id, $controller = null, $action = null, $plugin = null)
	{
		if(!empty($action)){

			$data = array('id'=>$id, 'plugin' => $plugin, 'controller' => $controller, 'view' => $action);
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
