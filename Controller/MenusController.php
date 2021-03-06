<?php

App::uses('Admin', 'Admin.Lib');
App::uses('AdminAppController', 'Admin.Controller');

class MenusController extends AdminAppController {


	var $helpers = array('Admin.AdminForm', 'Media.Media');
    var $uses = array('Admin.Menu');


    public $adminName = 'Menus';
    public $adminViews = array(
                    'root_menu' => array(
                        'title' => 'Contient d\'autres liens'
                    ));

    public $adminCapabilities = array(
            'create_menu' => 'Créer un menu',
            'edit' => 'Modifier les menus',
            'delete' => 'Supprimer les menus',
            'list' => 'Voir les menus',
        );

    public function beforeFilter()
    {
        $this->Security->blackHoleCallback = 'blackhole';
        parent::beforeFilter();

        if(empty($this->params['prefix']))
        {
            $this->layout = 'default';
            $this->Auth->allow();
            return;
        }
        if(Admin::hasCapability('admin.admin.index'))
        {
            $this->Auth->allow(array('admin_save', 'root_menu', 'admin_edit'));
        }
        if(Admin::hasCapability('admin.menus.create_menu'))
        {
            $this->Auth->allow(array('admin_create_page'));
        }
    }

    public function blackhole($type)
    {
        //exit(debug($type));
    }

    public function admin_edit($id) {
        $menu = $this->Menu->findById($id);
        if(empty($menu['Menu']['controller']))
        {
			$this->redirect(array('action' => 'create_page', $id));
			exit();
        }
        $menu['Menu']['custom_fields'] = json_decode($menu['Menu']['custom_fields'], true);

        $view = Admin::getAdminView($menu);
        $url = $view['edit']['url'];
       	$this->set('id', $id);
        $this->request->data = $menu;

        $menu_item_panel_header = false;
        $menu_item_content = '';
        if(Admin::hasCapability($this->Auth->user(), $url))
        {
            if($view['edit_panel_header']['exists'])
            {
                $Obj = Admin::getController($menu);
                $method = $view['edit_panel_header']['method'];
                $menu_item_panel_header = $Obj->$method($menu['Menu']['args']);
            }
            if($view['edit']['exists'] && Admin::hasCapability($this->Auth->user(), $url))
            {
                $menu_item_content = $this->requestAction($url, array('return', 'named' => array('admin_panel' => 1)));
            }
        }
        $this->set('menu_item_content', $menu_item_content);
        $this->set('menu_item_panel_header', $menu_item_panel_header);
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
    public function admin_setDefault($id) {

        $this->Menu->id = $id;
    	if(!$this->Menu->exists())
    	{
    		exit('{"error":true, "message":"menu item does not exists"}');
        }
        if($this->Menu->updateAll(array(
            'Menu.default' => 0), array(
            'Menu.default' => 1)))
        {
            $this->Menu->id = $id;
            $this->Menu->saveField('default', 1);
            exit('{"success":1,"error":0}');
        }
        exit('{"error":1, "message":"unknown error"}');
    }
    public function admin_save() {
    	if(!$this->request->is('put'))
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
        	$this->request->data['Menu']['args'] = $args;
            $fields = array();
            if(!Admin::hasCapability('admin.menus.edit'))
            {
                $fields = array('args');
            }
            else
            {
                if(empty($this->request->data['Menu']['slug']))
                {
                    $this->request->data['Menu']['slug'] = $this->request->data['Menu']['title'];
                }
                App::uses('Inflector', 'Utility');
                $this->request->data['Menu']['slug'] = Inflector::slug($this->request->data['Menu']['slug'], '-');
            }
            if(!empty($this->request->data['Menu']['custom_fields']))
            {
                $this->request->data['Menu']['custom_fields'] = json_encode($this->request->data['Menu']['custom_fields']);
            }
		    if($this->Menu->save($this->request->data, true, $fields))
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
        	$this->Session->setFlash(__('Erreur pendant la sauvegarde. (erreur du modèle associé)'), 'Admin.flash_error');
        }

    	$this->redirect(array('action' =>'edit', $id));
    }
	public function admin_root_menu($id=null) {
        if(!empty($this->request->data))
        {
            return base64_encode(json_encode($this->request->data['RootMenuOptions']));
            //return implode(';', $this->request->data['RootMenuOptions']);
        }
        $this->request->data['RootMenuOptions'] = json_decode(base64_decode($id), true);
        //list($redirectTo) = explode(';',$id);
        //$this->request->data['RootMenuOptions'] = array('redirectTo' => $redirectTo);
		$this->layout = 'Admin.admin_panel';
	}
    public function root_menu($id = null)
    {
        $menuOptions = json_decode(base64_decode($id), true);
        if(!empty($menuOptions['redirectTo']))
        {
            $this->redirect($menuOptions['redirectTo']);
            exit();
        }
        $menus = $this->Menu->children(Configure::read('Admin.Menu.id'), true);
        $this->set('menus', $menus);
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
	public function admin_create_page($id, $controller = '', $action = '', $plugin = '')
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

    public function admin_list() {
        //$d = array('Menu'=>array('parent'))
        return $this->Menu->find('threaded');
    }
    public function getGeneratedTreeList() {
        return $this->Menu->generateTreeList(null, '{n}.Menu.slug', '{n}.Menu.title', '_');
    }
    public function getList($parent_id, $depth) {
        //$d = array('Menu'=>array('parent'))
        $Menus = $this->Menu->children($parent_id);
        $MenuById = array();
        $MenuById[$parent_id] = array('children' => array());

        foreach($Menus as &$M)
        {
            $M['children'] = array();
            $MenuById[$M['Menu']['id']] = &$M;
        }
        foreach($Menus as &$M)
        {
            $MenuById[$M['Menu']['parent_id']]['children'][] = &$M;
        }
        return $MenuById[$parent_id]['children'];
    }

}
