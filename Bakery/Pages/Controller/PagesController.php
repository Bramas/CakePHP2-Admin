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
	public $uses = array('Page');

	public $components = array('Auth');

	public $helpers = array('Admin.AdminForm');

	public $adminViews = array(
					'display' => array(
						'title' => 'Afficher une page simple'
					));

	public function admin_display_delete($id=null) {
		return $this->Page->delete($id);
	}
	public function admin_display($id=null) {

        if (!empty($this->request->data)) {
        	if(empty($id))
        	{
        		if(empty($this->request->data['Page']))
        		{
        			return false;
        		}
        		$this->request->data['Page']['author_id'] = $this->Auth->user('id');
        	}
        	if($this->Page->save($this->request->data))
        	{
        		return $this->Page->id;
        	}
        	return false;
        }

		$this->layout = 'Admin.admin_panel';
		$this->request->data = $this->Page->findById($id);
	}
	public function display($id) {
		$this->set($this->Page->findById($id));
	}
}
