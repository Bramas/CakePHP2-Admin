<?php

class UsersController extends AdminAppController {


    public function beforeFilter()
    {
        $this->Auth->allow(array('add', 'login', 'logout'));
        return parent::beforeFilter();
    }

    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('User invalide'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            $this->User->set($this->request->data);
            if(!$this->User->validates())
            {
                $this->Session->setFlash(__('Le formulaire n\'a pas été correctement rempli'), 'Admin.flash_warning'); 
                $this->set('errors', $this->User->validationErrors);
            }
            else
            if ($this->User->save()) {
                $this->Session->setFlash(__('L\'utilisateur a été sauvegardé'), 'Admin.flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('L\'utilisateur n\'a pas été sauvegardé. Merci de réessayer.'), 'Admin.flash_error');
            }
        }
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('User Invalide'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('L\'utilisateur a été sauvegardé'), 'Admin.flash_success');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('L\'utilisateur n\'a pas été sauvegardé. Merci de réessayer.'), 'Admin.flash_error');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        $this->request->onlyAllow('post');

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
                return $this->redirect($this->Auth->redirect());
            } else {
                debug($this->request->data);
                $this->Session->setFlash(__("Nom d'utilisateur ou mot de passe invalide, réessayer"), 'Admin.flash_warnin');
            }
        }
        $this->layout = 'Admin.login';
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

}