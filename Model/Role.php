<?php

App::uses('AppModel','Model');
class Role extends AppModel
{
	public $hasMany = array('Admin.User');
	public $hasAndBelongsToMany = array('Admin.Capability');
}