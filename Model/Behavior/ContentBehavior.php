<?php

class ContentBehavior extends ModelBehavior
{
	public function setup(Model $Model, $settings = array()) 
	{
		if (!isset($this->settings[$Model->alias])) 
		{
			$this->settings[$Model->alias] = array('recursive' => true, 'notices' => true, 'autoFields' => true);
		}
		$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
	}

	public function beforeSave(Model $Model)
	{
		if(empty($Model->data[$Model->alias][$Model->primaryKey]))
		{
			$data = $Content->find
		}
		//$Model->data	
	}

	public function beforeFind(Model $Model, $query) 
	{
	}
	
}