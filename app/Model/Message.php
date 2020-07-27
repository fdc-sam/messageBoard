<?php

App::uses('Model', 'Model');


class Message extends Model {
	public $name = 'Message';
	public $displayField = 'name';


	// public $belongsTo = array(
	// 	'Friend' => array(
	// 		'className' => 'Friend',
	// 		'foreignKey' => 'user_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// 	'User' => array(
	// 		'className' => 'User',
	// 		'foreignKey' => 'user_id',
	// 		'conditions' => '',
	// 		'fields' => '',
	// 		'order' => ''
	// 	),
	// );

}
