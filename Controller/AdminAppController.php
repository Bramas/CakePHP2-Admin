<?php

class AdminAppController extends AppController {

    public $components = array(
        'Session',
        'Auth' => array(
            'authorize' => array('Controller'),
            'authenticate' => array(
                'Basic' => array(
                    'userModel' => 'Admin.User', 
                    'passwordHasher' => 'Blowfish'),
                'Form' => array(
                    'userModel' => 'Admin.User', 
                    'passwordHasher' => 'Blowfish')
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
    }


    public function isAuthorized($user) {
        // Admin peut accéder à toute action
        if (isset($user['role_id']) && $user['role_id'] == '1') {
            return true;
        }

        // Refus par défaut
        return false;
    }

}
