<?php

App::uses('Admin', 'Admin.Lib');

class UsersController extends AdminAppController {


    public function beforeFilter(){

        parent::beforeFilter();
        $this->Security->unlockedActions = array('login');
        if($_SERVER['REMOTE_ADDR'] == '132.227.84.106')
        {
            //debug($this->request->params);
        }
        if(empty($this->params['prefix']))
        {
            $this->Auth->allow();
        }
        if($this->request->params['action'] == 'admin_edit' AND
         !empty($this->request->params['pass']) &&
          is_array($this->request->params['pass']) &&
           count($this->request->params['pass']) &&
            current($this->request->params['pass']) == $this->Auth->user('id'))
        {
            $this->Auth->allow();
        }
    }

    public function admin_index() {
        $this->User->recursive = 0;
        $this->set('Users', $this->paginate());
    }

    public function admin_view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('User invalide'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function admin_add() {
    }

    public function admin_edit($id = null) {
        $this->set('Roles', $this->User->Role->find('list'));

        if (!empty($this->request->data)) {
            $this->User->create();
            $this->User->set($this->request->data);
            if(!empty($this->request->data['User']['new_password']) || 
                !empty($this->request->data['User']['new_password_confirm']))
            {
                $pass1 = $this->request->data['User']['new_password'];
                $pass2 = $this->request->data['User']['new_password_confirm'];
                if($pass1 !== $pass2)
                { 
                    $this->Session->setFlash(__('Les mots de passe doivent être identiques'), 'Admin.flash_warning'); 
                    return;
                }
                $this->request->data['User']['password'] = $pass1;
                $this->User->set($this->request->data);
            }
            if(!$this->request->data['User']['id'] && !$this->User->validates())
            {
                $this->Session->setFlash(__('Le formulaire n\'a pas été correctement rempli'), 'Admin.flash_warning'); 
                $this->set('errors', $this->User->validationErrors);
                return;
            }
            else
            if ($this->User->save(null, false)) {
                $this->Session->setFlash(__('L\'utilisateur a été sauvegardé'), 'Admin.flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('L\'utilisateur n\'a pas été sauvegardé. Merci de réessayer.'), 'Admin.flash_error');
            }
            $this->redirect(array($this->User->id));
            exit();
        }

        $this->User->id = $id;
        if ($this->User->exists()) {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
        
    }

    public function admin_delete($id = null) {

        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('User invalide'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User supprimé'), 'Admin.flash_success');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('L\'utilisateur n\'a pas été supprimé'), 'Admin.flash_error');
        return $this->redirect(array('action' => 'index'));
    }

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                if($this->request->is('ajax'))
                {
                    exit('{"success":1}');
                }
                return $this->redirect($this->Auth->redirect());
            } else {
                if($this->request->is('ajax'))
                {
                    exit('{"success":0, "message":"'.__("Nom d'utilisateur ou mot de passe invalide, réessayer").'"}');
                }
                $this->Session->setFlash(__("Nom d'utilisateur ou mot de passe invalide, réessayer"), 'Admin.flash_warning');
            }
        }
        $this->layout = 'Admin.login';
    }

    public function logout() {
        $this->Auth->logout();
        return $this->redirect('/');
    }
    public function currentUser() {
        return $this->Auth->user();
    }

}