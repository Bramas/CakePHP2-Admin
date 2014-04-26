<?php

class InstallShell extends AppShell {
    public function main() {
        $this->out(__('Bienvenue dans l\'installation du plugin Admin.'));

		$this->dispatchShell('schema create DbAdmin --plugin Admin');


		App::uses('Menu', 'Admin.Model');   
		$this->Menu = new Menu();   
        $this->Menu->create();  
        $this->Menu->save(array(
        	'plugin' => 'Admin',
        	'controller' => 'menus',
        	'view' 		=> 'menu_edit',
        	'default'	=> 1,
        	'slug' => __('Menu-Principal'),
        	'title' => __('Menu Principal')));

		$this->out('Create Main Menu: DONE'); 
        $this->hr();  

		App::uses('Role', 'Admin.Model');   
		$this->Role = new Role();   
        $this->Role->create();  
        $this->Role->save(array(
        	'alias' => 'administrator',
        	'name' => 'Administrator',
        	'protected'	=> 1)); 
        $this->Role->create();  
        $this->Role->save(array(
        	'alias' => 'default',
        	'name' => __('Visiteur'),
        	'protected'	=> 1));

		$this->out('Create Default Roles: DONE'); 
        $this->hr();  

		$this->out('Create Admin User:'); 
        $this->hr(); 
         
        while (empty($username)) { 
          $username = $this->in('Username:'); 
          if (empty($username)) $this->out('Username must not be empty!'); 
        } 
         
        while (empty($pwd1)) { 
          $pwd1 = $this->in('Password:'); 
          if (empty($pwd1)) $this->out('Password must not be empty!'); 
        } 
         
        while (empty($pwd2)) { 
          $pwd2 = $this->in('Password Confirmation:'); 
          if ($pwd1 !== $pwd2) { 
            $this->out('Passwort and confirmation do not match!'); 
            $pwd2 = NULL; 
          } 
        } 
         
		App::uses('User', 'Admin.Model');  
		$this->User = new User();   
        $this->User->create(); 

		if ($this->User->save(array(
			'role_id' => 1, 
			'username' => $username, 
			'password' => $pwd1))) { 
			$this->out('Admin User created successfully!'); 
		} else { 
			$this->out('ERROR while creating the Admin User!!!'); 
		} 
    }
}