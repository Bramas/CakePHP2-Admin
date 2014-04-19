<?php

Router::connect(
	'/admin',
	array('controller' => 'admin', 'action' => 'index', 'plugin'=>'admin', 'admin' => true)
);

Router::connect(
	'/users/:action',
	array('controller' => 'users', 'plugin'=>'admin')
);