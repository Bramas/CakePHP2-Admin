<?php


Router::connect(
	'/admin/menus/:action',
	array('controller' => 'menus', 'plugin'=>'admin', 'admin' => true)
);

Router::connect(
	'/admin/menus/:action/*',
	array('controller' => 'menus', 'plugin'=>'admin', 'admin' => true)
);



Router::connect(
	'/users/:action',
	array('controller' => 'users', 'plugin'=>'admin', 'admin' => false)
);
Router::connect(
	'/admin/users/login',
	array('controller' => 'users', 'plugin'=>'admin', 'admin' => false, 'action' => 'login')
);


/*Router::connect(
	'/admin/users/:action',
	array('controller' => 'users', 'plugin'=>'admin', 'admin' => false)
);

Router::connect(
	'/admin/users/:action/*',
	array('controller' => 'users', 'plugin'=>'admin', 'admin' => false)
);*/



Router::connect(
	'/admin/:controller',
	array('action'=>'index', 'admin'=>true)
);
Router::connect(
	'/admin/:controller/:action',
	array('admin'=>true)
);
Router::connect(
	'/admin/:controller/:action/*',
	array('admin'=>true)
);

Router::connect(
	'/admin',
	array('controller' => 'admin', 'action' => 'index', 'plugin'=>'admin', 'admin' => true)
);



App::uses('AdminRoute', 'Admin.Routing/Route');
$routeClass = 'AdminRoute';

Router::connect('/', 
	array(),
	array('routeClass' => 'AdminRoute')
);

Router::connect('/:slug', array(),
						array(
                        	'routeClass' => $routeClass
                        ));
Router::connect('/:slug/*', array(),
						array(
                        	'routeClass' => $routeClass
                        ));


