<?php

class AdminAppController extends AppController {

    public $components = array(
        'Session',
        'Auth' => array(
            'authorize' => array('Controller'),
            'authenticate' => array(
                'Basic' => array('userModel' => 'Admin.User'),
                'Form' => array('userModel' => 'Admin.User')
                )
        )
    );
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->layout = 'admin';
    }


    public function isAuthorized($user) {
        // Admin peut accéder à toute action
        if (isset($user['role']) && $user['role'] === 'administrator') {
            return true;
        }

        // Refus par défaut
        return false;
    }

}
