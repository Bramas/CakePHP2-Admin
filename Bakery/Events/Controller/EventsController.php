<?php

App::uses('AppController', 'Controller');
App::uses('AdminAuthorize', 'Controller/Component/Auth');


class EventsController extends AppController {

	public $uses = array('Event', 'Admin.Config');

	public $components = array(
		'Security',
		'Auth' => array(
			'authorize' => array('Admin.Admin')
			)
		);

	public $helpers = array('Admin.AdminConfig','Admin.AdminForm','Upload.Upload');

	public $adminViews = array(
					'index' => array(
						'title' => 'Afficher la liste des événements',
						'edit' => 'index_options'
					));
	public $adminMenu = array(
			'Agenda' => array(
				'action' => 'index'
				)
			);
	public $adminCapabilities = array(
			'index' => 'Voir la liste des évènements',
			'edit' => 'Modifier les évènements',
			'publish' => 'Publier les nouveaux évènements et les modifications',
			'create' => 'Créer un évènements',
			'delete' => 'Supprimer les évènements'
		);

	public function beforeFilter()
	{
		if($this->request->prefix == 'admin')
		{
			$this->layout = 'Admin.admin';
			if(!empty($_GET['ajax']))
			{
				$this->layout = 'Admin.ajax';
			}
		}
		parent::beforeFilter();
        if(empty($this->params['prefix']))
        {
            $this->Auth->allow();
        }
	}

	public function admin_edit($id = 0) {

        if ($this->request->is('post') || $this->request->is('put')) {
        	/*if(false !== strpos('/', $this->request->data['Event']['begin']))
        	{
        		list($j,$m,$a) = explode('/',$this->request->data['Event']['begin']);
				$this->request->data['Event']['begin'] = $a.'-'.$m.'-'.$j.' 00:00:00';
        	}
        	else
        	{
        		$this->request->data['Event']['begin'] = false;
        	}
        	if(false !== strpos('/', $this->request->data['Event']['end']))
        	{
        		list($j,$m,$a) = explode('/',$this->request->data['Event']['end']);
				$this->request->data['Event']['end'] = $a.'-'.$m.'-'.$j.' 00:00:00';
        	}
        	else
        	{
        		$this->request->data['Event']['end'] = false;
        	}*/
        	if(empty($id))
        	{
        		if(empty($this->request->data['Event']))
        		{
        			return false;
        		}
        		$this->request->data['Event']['author_id'] = $this->Auth->user('id');
        	}
        	if($this->Event->save($this->request->data))
        	{
        		$this->Session->setFlash(__('La news a bien été enregistrée.'), 'Admin.flash_success');
        		$this->redirect(array($this->Event->id));
        		exit();
        	}
        	$this->Session->setFlash(__('Erreur pendant l\'enregistrement.'), 'Admin.error');
        }
        if(!empty($id))
        {
        	$this->request->data = $this->Event->findById($id);
        }
	}
	public function admin_index_options($options = null) {
		if(!empty($this->request->data))
		{
			return implode('-',$this->request->data['EventOptions']);
		}
		if(strpos($options, '-') === false)
		{
			$count = 10;
			$type = 'list';
		}
		else
		{
			list($count, $type) = explode('-',$options);
		}
		$this->request->data['EventOptions'] = array(
			'count'=>$count,
			'type' =>$type);
	}

	public function admin_index() {
		//debug($this->Event->find('all'));
		$this->set('Events', $this->Event->find('all'));
	}
	public function admin_delete($id) {
		$this->Event->delete($id);
		$this->redirect(array('action' => 'index'));
		exit();
	}
	public function view($id) {
		debug($this->Event->find('all'));
	}
	public function index($options) {
		list($count, $type) = explode('-',$options);
		$this->set('Events', $this->Event->find('all',array(
			'limit' => $count)));
		$this->set('type', $type);
	}
}
