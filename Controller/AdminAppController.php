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
        parent::beforeFilter();
        $this->set('User', $this->Auth->user());
    }


    public function isAuthorized($user) {
        return false;
    }

}
