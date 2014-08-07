<?php

App::uses('Admin', 'Admin.Lib');
App::uses('AdminAppController', 'Admin.Controller');

class SearchController extends AdminAppController {


    public function beforeFilter(){
        parent::beforeFilter();
        //if(empty($this->params['prefix']))
        {
            $this->Auth->allow();
        }
		$this->layout = 'default';
    }
	public function index()
	{
		if(!$this->request->is('get') || empty($this->request->query['terms']))
		{
			//$this->redirect('/');
			//exit();
		}
		$terms = $this->request->query['terms'];
		$ControllersInfo = Admin::getControllersInfo();
		$results = array();
		foreach($ControllersInfo as $ControllerInfo)
		{
			if(empty($ControllerInfo['adminSearch']))
			{
				continue;
			}
			$adminSearch = $ControllerInfo['adminSearch'];
			$controllerClass = $ControllerInfo['controllerClass'];
			$C = new $controllerClass();
			$r = $C->$adminSearch($terms);
			$results = array_merge((array)$results, (array)$r);
		}
		$this->set('results', $results);
	}
}

?>