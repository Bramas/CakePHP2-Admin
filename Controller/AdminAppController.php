<?php

App::uses('AppController', 'Controller');
class AdminAppController extends AppController {

    public $components = array(
        'Security',
        'Session',
        'Auth' => array(
            'authorize' => array('Admin.Admin', 'Controller'),
            'authenticate' => array(
                'Form' => array(
                    'userModel' => 'Admin.User', 
                    'passwordHasher' => 'Blowfish',
                    'recursive' => 2)
                )
        )
    );
    public $helpers = array('Media.Static');
    public function blackhole($type) {
        exit($type);
    }
    public function beforeFilter()
    {
        if(!empty($_GET['ajax']))
        {
            $this->layout = 'ajax';
        }
        else
        {
            $this->layout = 'admin';
        }
        //$this->Security->blackHoleCallback = 'blackhole';
        parent::beforeFilter();
        $this->set('User', $this->Auth->user());
    }


    public function isAuthorized($user) {
        return false;
    }

}
