<?php

App::uses('AppController', 'Controller');
App::uses('AdminAuthorize', 'Controller/Component/Auth');


class EventsController extends AppController {

	public $uses = array('Event');

	public $components = array(
		'Security',
		'Auth' => array(
			'authorize' => array('Admin.Admin')
			)
		);

	public $helpers = array('Media.Static','Admin.AdminConfig','Admin.AdminForm','Upload.Upload');

	public $adminName = 'Evénements';
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
	public $adminSearch = 'search';
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
        	if(empty($id))
        	{
        		if(empty($this->request->data['Event']))
        		{
        			return false;
        		}
        		$this->request->data['Event']['author_id'] = $this->Auth->user('id');
        	}
        	
        	$date = DateTime::createFromFormat('d/m/Y', $this->request->data['Event']['event_date']);
        	if($date)
        	{
        		$this->request->data['Event']['event_date'] = $date->format('Y-m-d');
        	}
        	$date_end = DateTime::createFromFormat('d/m/Y', $this->request->data['Event']['event_end']);
        	if($date_end)
        	{
        		$this->request->data['Event']['event_end'] = $date_end->format('Y-m-d');
        	}
        	
        	if($this->Event->save($this->request->data))
        	{
        		$this->Session->setFlash(__('L\'événement a bien été enregistrée.'), 'Admin.flash_success');
        		$this->redirect(array($this->Event->id));
        		exit();
        	}
        	$this->Session->setFlash(__('Erreur pendant l\'enregistrement.'), 'Admin.error');
        }
        elseif(!empty($id))
        {
        	$this->request->data = $this->Event->findById($id);
        }
        if(!empty($this->request->data['Event']))
        {
        	$date = DateTime::createFromFormat('Y-m-d', $this->request->data['Event']['event_date']);
			if($date)
			{
        		$this->request->data['Event']['event_date'] = $date->format('d/m/Y');
			}
        	$date_end = DateTime::createFromFormat('Y-m-d', $this->request->data['Event']['event_end']);
        	if($date_end)
        	{
        		$this->request->data['Event']['event_end'] = $date_end->format('d/m/Y');
        	}
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
	public function view($slug) {
		if(strpos($slug, '-') === false)
		{
			$id = $slug;
		}
		else
		{
			list($id) = explode('-', $slug); 
		}
		$e = $this->Event->findById($id);
		$this->redirect(array('action'=>'day', $e['Event']['event_date']));
		exit();
	}
	public function day($slug) {
		if(strpos($slug, '-') === false)
		{
			$this->redirect('/');
			exit();
		}
		else
		{
			list($anne, $mois, $jour) = explode('-', $slug); 
		}
		$this->set('date', $slug);
		$this->set('Events', $this->Event->find('all',
		array(
		'conditions' => array(
		array('OR'=>array(
			'event_date' => $slug,
			'AND' => array(
				'event_date <=' => $slug,
				'event_end >='	=> $slug
				)
		))))));
	}
	public function index($options = "10-list") {
		$nextEvent = $this->Event->find('first',
			array(
			'conditions'=>array(
				'event_date >=  NOW()'
				),
			'order' => array(
				'event_date'
				)
			));
		if(!empty($nextEvent))
		{
			$controller = 'events';
			if(Configure::read('Admin.Menu.slug'))
			{
				$controller = Configure::read('Admin.Menu.slug');
			}
			$this->redirect('/'.$controller.'/day/'.$nextEvent['Event']['event_date']);
			exit();
		}
	}
	public function getList($all = null, $count=10) {
		$options = array(
			'order' => array('Event.event_date')
		); 
		if($all != 'all')
		{
			$options['conditions'] = array(
					 'OR' => array(
					 	'event_date >= NOW()',
					 	'event_end >= NOW()'
					));
			$options['limit'] = $count;
		}
		$Events = $this->Event->find('all', $options);
		if($all == 'all')
		{			
            $Events = Set::combine($Events,'{n}.Event.id','{n}.Event','{n}.Event.event_date');
			
			$eventsCopy = $Events;

			foreach($eventsCopy as $day => $eventsArray)
			{
				foreach($eventsArray as $event)
				{
					if($event['event_date'] == $day && $event['event_end'] && $event['event_end'] > $event['event_date'])
					{
						$date = DateTime::createFromFormat('Y-m-d', $event['event_date']);
						date_add($date,new DateInterval('P1D'));
						$date_end = DateTime::createFromFormat('Y-m-d', $event['event_end']);
						while($date <= $date_end)
						{ 
							/*if(!isset($Events_add[$date_end->format('Y-m-d')]))
							{
								$Events_add[$date_end->format('Y-m-d')] = array();
							}*/
							$Events[$date->format('Y-m-d')][] = $event;
							$date->add(new DateInterval('P1D'));
						}
					}
				}
			}
		}
		return $Events;
	}
	public function search($terms)
	{
	
		$controller = 'events';
		$config = $this->requestAction('/config/get/events');
		if(!empty($config['parent_menu']))
		{
			$controller = $config['parent_menu'];
		}	
		$model = 'Event';
		$db = $this->$model->getDataSource();
		$results = $db->fetchAll(
		    "SELECT $model.title, $model.content, $model.id, MATCH (title, content) ".
		    'AGAINST (:terms IN BOOLEAN MODE) as Score '.
			"FROM ".$this->$model->tablePrefix."events as $model ".
			'HAVING Score > 0.2 ORDER BY Score DESC',
		    array('terms' => $terms)
		);
		$ret = array();
		foreach($results as $res)
		{
			$ret[] = array(
				'url' => array(
					'controller' => $controller,
					'action' => 'view',
					$res[$model]['id'].'-'.Inflector::slug($res[$model]['title'], '-')
					),
				'title' => $res[$model]['title'],
				'score' => $res[0]['Score'],
				'type' => 'Evénement',
				'abstract' => $res[$model]['content']
				);
		}
		return $ret;
	}
}
