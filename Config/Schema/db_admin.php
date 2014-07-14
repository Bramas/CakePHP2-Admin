<?php
class DbAdminSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 50),
		'password' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 100),
		'role_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'rights' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 1000),
		'email' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 250),
		'email_verified' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1), 
		'active' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),
		'ip_address' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 50),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'params' => array('type' => 'text', 'null' => false, 'default' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
	    'tableParameters' => array(
	        'engine' => 'InnoDB',
	        'charset' => 'utf8',
	        'collate' => 'utf8_general_ci',
	        'encoding' => 'utf8_general_ci'
		    )
		);

	public $menus = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'lft' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'rght' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'plugin' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 150),
		'controller' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 150),
		'view' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 250),
		'args' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 1000),
		'title' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 500),
		'slug' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 500),
		'default' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 1),		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		    'tableParameters' => array(
		        'engine' => 'InnoDB',
		        'charset' => 'utf8',
		        'collate' => 'utf8_general_ci',
		        'encoding' => 'utf8_general_ci'
			    )
		    );
	public $roles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'alias' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 100),
		'parent_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'protected' => array('type' => 'integer', 'null' => false, 'default' => '', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array(
		        'engine' => 'InnoDB',
		        'charset' => 'utf8',
		        'collate' => 'utf8_general_ci',
		        'encoding' => 'utf8_general_ci'
			    )
		    );
	public $user_capabilities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'capability' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50),
		'args' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array(
		        'engine' => 'InnoDB',
		        'charset' => 'utf8',
		        'collate' => 'utf8_general_ci',
		        'encoding' => 'utf8_general_ci'
			    )
		    );
			
	public $role_capabilities = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'role_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'capability' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50),
		'args' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array(
		        'engine' => 'InnoDB',
		        'charset' => 'utf8',
		        'collate' => 'utf8_general_ci',
		        'encoding' => 'utf8_general_ci'
			    )
		    );
			
}