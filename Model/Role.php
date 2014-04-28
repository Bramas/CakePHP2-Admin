<?php

App::uses('AppModel','Model');
class Role extends AppModel
{
	public $hasMany = array(
		'Admin.User',
        'Capability' => array(
            'className' => 'Admin.RoleCapability',
            'conditions' => array('args' => null)
            ),
        'AdditionnalCapability' => array(
            'className' => 'Admin.RoleCapability',
            'conditions' => array('args IS NOT NULL')
            ));
}