<?php

App::uses('AppController', 'Controller');
App::uses('AdminAuthorize', 'Controller/Component/Auth');


class PostsController extends AppController {

	public $uses = array('Post');

	public $components = array(
		'Auth' => array(
			'authorize' => array('Admin.Admin')
			)
		);

	public $helpers = array('Admin.AdminForm','Upload.Upload');

	public $adminViews = array(
					'index' => array(
						'title' => 'Afficher la liste des actualité',
						'edit' => 'index_options'
					));
	public $adminMenu = array(
			'Actualités' => array(
				'action' => 'index'
				)
			);
	public $adminCapabilities = array(
			'index' => 'Voir la liste des actualités',
			'edit' => 'Modifier les actualités',
			'publish' => 'Publier les nouvelles actualités et les modifications',
			'create' => 'Créer une actualité',
			'delete' => 'Supprimer les actualités'
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
	}

	public function admin_edit($id = 0) {

        if ($this->request->is('post') || $this->request->is('put')) {
        	if(empty($id))
        	{
        		if(empty($this->request->data['Post']))
        		{
        			return false;
        		}
        		$this->request->data['Post']['author_id'] = $this->Auth->user('id');
        	}
        	if($this->Post->save($this->request->data))
        	{
        		$this->Session->setFlash(__('La news a bien été enregistrée.'), 'Admin.flash_success');
        		$this->redirect(array($this->Post->id));
        		exit();
        	}
        	$this->Session->setFlash(__('Erreur pendant l\'enregistrement.'), 'Admin.error');
        }
        if(!empty($id))
        {
        	$this->request->data = $this->Post->findById($id);
        }
	}
	public function admin_index_options($options = null) {
		if(!empty($this->request->data))
		{
			return implode('-',$this->request->data['PostOptions']);
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
		$this->request->data['PostOptions'] = array(
			'count'=>$count,
			'type' =>$type);
	}

	public function admin_index() {
		//debug($this->Post->find('all'));
		$this->set('Posts', $this->Post->find('all'));
	}
	public function admin_delete($id) {
		$this->Post->delete($id);
		$this->redirect(array('action' => 'index'));
		exit();
	}
	public function view($id) {
		debug($this->Post->find('all'));
	}
	public function index($options) {
		list($count, $type) = explode('-',$options);
		$this->set('Posts', $this->Post->find('all',array(
			'limit' => $count)));
		$this->set('type', $type);
	}
}
