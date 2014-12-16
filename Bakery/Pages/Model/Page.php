<?php

class Page extends AppModel
{

	var $belongsTo = array('User' => array(
			'foreignKey' => 'author_id',
			'className'  => 'Admin.User'
		));

	public function revisions($parent_id = null){
		if(!isset($parent_id)){
			$parent_id = $this->field($parent_id);
		}
		return $this->find('all', array(
			'conditions' => array(
				'parent_id' => $parent_id
				),
			'order' => array('Page.created DESC'),
			'recursive' => 1
			));
	}
	private function getLastPendingId($id, $author_id)
	{
		$first = $this->find('first', array(
			'conditions'=> array(
				'author_id' => $author_id,
				'parent_id' => $id,
				'status'    => 'pending'
			),
			'order' => array('Page.created' => 'DESC')));
		if(empty($first))
		{
			return null;
		}
		return $first['Page']['id'];
	}
	public function savePending($data)
	{
		$data['Page']['status'] = 'pending';

		$this->id = $data['Page']['id'];
		if(empty($this->id))
		{
			$this->save($data);
			$this->saveField('parent_id', $this->id);
			return true;
		}
		if($this->field('status') == 'pending')
		{
			return $this->save($data);
		}
		$data['Page']['id'] = null;
		$this->create();
		return $this->save($data);
	}

	public function findLastPublishedVersion($id)
	{
		$conditions = array(
			'parent_id' => $id,
			'status' => 'published'
			);

		$first = $this->find('first', array(
			'conditions'=> $conditions,
			'order' => array('Page.created' => 'DESC')));

		if(!empty($first))
		{
			return $first;
		}
		return $this->findById($id);
	}

	public function findLastVersion($id, $author_id = null)
	{
		$conditions = array('parent_id' => $id);
		if(isset($author_id))
		{
			$conditions['author_id'] = $author_id;
		}
		$first = $this->find('first', array(
			'conditions'=> $conditions,
			'order' => array('Page.created' => 'DESC')));

		if(!empty($first))
		{
			return $first;
		}
		if(isset($author_id))
		{
			return $this->findLastVersion($id, null);
		}
		return  $this->findById($id);
	}

	public function publish($data)
	{
		$data['Page']['status'] = 'published';
		$new = empty($data['Page']['id']);
		$this->create();
		$ok = $this->save($data);
		if($new)
		{
			$this->saveField('parent_id', $this->id);
		}
		return $ok;
	}
}