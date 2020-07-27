<?php

App::uses('Model', 'Model');


class Friend extends Model {
	public $name = 'Friend';
	public $displayField = 'name';

	// public $hasMany = array(
  //   'friends' => array(
  //       'className' => 'friends', // table name
  //   )
  // );

  public $belongsTo = array(
    'User' => array(
        'className' => 'User', // table name
    )
  );


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
