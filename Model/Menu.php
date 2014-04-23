<?php

App::uses('AppModel','Model');
class Menu extends AppModel
{
	var $actsAs = array('Tree');
	
	public function beforeFind($query)
	{
		if(empty($query['order'])
			|| (is_array($query['order']) && empty($query['order'][0])))
		{
			$query['order'] = array('Menu.lft ASC');
		}
		return $query;
	}
}