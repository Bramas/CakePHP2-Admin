<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');
App::uses('Admin', 'Admin.Lib');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Page', 'Admin.Menu');

	public $components = array(
		'Security',
		'Auth'=>array(
			'authorize' => array('Admin.Admin')
			)
		);

	public $adminName = 'Pages';
	public $helpers = array('Media.Static', 'Admin.AdminForm');

	public $adminViews = array(
					'display' => array(
						'title' => 'Afficher une page simple'
					));
	public $adminCapabilities = array(
			'create' => 'Créer une nouvelle page',
			'display' => 'Modifier une page',
			'publish' => 'Publier les modifications d\'une page'
		);
		
	public $adminSearch = 'search';
	
    public function beforeFilter(){
        parent::beforeFilter();
        
        if(empty($this->params['prefix']))
        {
            $this->Auth->allow();
        }
        if(Configure::read('Admin.Menu.default'))
        {
	        //$this->layout = 'home_page';
        }
        if(Admin::hasCapability('admin.menus.delete'))
        {
            $this->Auth->allow(array('admin_display_delete'));
        }
    }
	public function admin_display_delete($id=null) {
		return $this->Page->delete($id);
	}
	public function admin_display_panel_header($id=null) {	
		if(empty($id))
		{
			return false;
		}
		$canPublish = Admin::hasCapability('pages.publish');
		return array(
			'title' => 'Page',
			'submit' => ($canPublish ? __('Publier') : __('Soumettre à Publication'))
			);
	}
	public function admin_display($id=null) {	
		if(empty($id))
		{
			if(!Admin::hasCapability('pages.create'))
			{
				return false;
			}
		}
		$canPublish = Admin::hasCapability('pages.publish');
        if (!empty($this->request->data)) {
        	if(!empty($id))
			{
				$this->Page->id = $this->request->data['Page']['id'];
				if($this->Page->field('parent_id') != $id)
				{
					return false;
				}
			}
			else
			{
				$this->request->data['Page']['author_id'] = $this->Auth->user('id');
			}
        	
        	if(!$canPublish)
        	{
        		$this->request->data['Page']['author_id'] = $this->Auth->user('id');
    			if($this->Page->savePending($this->request->data))
    		 	{
    		 		return $this->Page->field('parent_id');
    		 	}
    		 	return false;
        	}
        	if($this->Page->publish($this->request->data))
        	{
        		return $this->Page->field('parent_id');
        	}
        	return false;
        }
        if($canPublish)
        {
        	$this->request->data = $this->Page->findLastVersion($id, null);
        }
        else
        {
        	$this->request->data = $this->Page->findLastVersion($id,$this->Auth->user('id'));
        }	
        if(!empty($this->request->data['Page']))
        {
        	$this->set('Revisions', $this->Page->revisions($this->request->data['Page']['parent_id']))	;
        } else {
        	$this->set('Revisions', array())	;
        }
	}

	public function admin_disapprove($id) {
		if(!Admin::hasCapability('pages.publish'))
		{
			$this->redirect('/');
			exit();
		}
		$this->Page->delete($id);
		$this->redirect($this->referer());
		exit();
	}
	public function display($id) {
		$this->set($this->Page->findLastPublishedVersion($id));
	}
	public function search($terms)
	{
		$db = $this->Page->getDataSource();
		$results = $db->fetchAll(
		    'SELECT Menu.slug, Page.id, Page.content, Menu.title, MATCH (Menu.title, Page.content) '.
		    'AGAINST (:terms IN BOOLEAN MODE) as Score '.
			'FROM '.$this->Page->tablePrefix.'pages as Page '.
			'INNER JOIN '.$this->Menu->tablePrefix.'menus as Menu ON (Menu.controller = "pages" AND Menu.args = Page.id) '.
			'HAVING Score > 0.2 ORDER BY Score DESC',
		    array('terms' => $terms)
		);
		$ret = array();
		foreach($results as $res)
		{
			$ret[] = array(
				'url' => array(
					'controller' => 'pages',
					'action' => 'view',
					'slug' => $res['Menu']['slug']
					),
				'title' => $res['Menu']['title'],
				'score' => $res[0]['Score'],
				'type' => 'Page',
				'abstract' => $res['Page']['content']
				);
		}
		return $ret;
	}
}
