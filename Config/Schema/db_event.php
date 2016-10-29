<?php
class DbEventSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $events = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'author_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'state' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 50),
		'title' => array('type' => 'string', 'null' => false, 'default' => '', 'length' => 50),
		'event_date' => array('type' => 'date', 'null' => true, 'default' => '', 'default' => null),
		'event_end'   => array('type' => 'date', 'null' => true, 'default' => '', 'default' => null),
		'content' => array('type' => 'text', 'null' => false, 'default' => ''),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
	    'tableParameters' => array(
	        'engine' => 'InnoDB',
	        'charset' => 'utf8',
	        'collate' => 'utf8_general_ci',
	        'encoding' => 'utf8_general_ci'
		    )
		);
}