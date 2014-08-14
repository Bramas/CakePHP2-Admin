<?php


Router::connect(
	'/users/:action',
	array('controller' => 'users', 'plugin'=>'admin', 'admin' => false)
);
Router::connect(
	'/admin/users/login',
	array('controller' => 'users', 'plugin'=>'admin', 'admin' => false, 'action' => 'login')
);

foreach(array(
	'users',
	'roles',
	'menus',
	'search',
	'config'
	) as $controller)
{
	Router::connect(
		'/admin/'.$controller,
		array('controller' => $controller, 'action' => 'index', 'plugin'=>'admin', 'admin' => true)
	);
	Router::connect(
		'/admin/'.$controller.'/:action',
		array('controller' => $controller, 'plugin'=>'admin', 'admin' => true)
	);

	Router::connect(
		'/admin/'.$controller.'/:action/*',
		array('controller' => $controller, 'plugin'=>'admin', 'admin' => true)
	);
	Router::connect(
		'/'.$controller,
		array('controller' => $controller, 'action' => 'index', 'plugin'=>'admin', 'admin' => false)
	);
	Router::connect(
		'/'.$controller.'/:action',
		array('controller' => $controller, 'plugin'=>'admin', 'admin' => false)
	);

	Router::connect(
		'/'.$controller.'/:action/*',
		array('controller' => $controller, 'plugin'=>'admin', 'admin' => false)
	);
}



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


