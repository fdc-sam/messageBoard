<?php

App::uses('Model', 'Model');

class User extends Model {
	public $name = 'User';
	public $displayField = 'name';

	public $validate = array(
		'name' => array(
			'lengthBetween' => array(
				'rule' => array('lengthBetween',5,20),
				'message' => 'Please enter 5-20 characters.',
			),
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter name.',
			),
		),
		'email' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
	            'message' => 'Please provide an email.'
			),
			'required' => array(
	            'rule' => array('email'),
	            'message' => 'Please enter a valid email.'
	        ),
			'unique' => array(
	            'rule' => 'isUnique',
	            'message' => 'Provided Email already exists.'
	        )
		),
		'password' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter a password.',
			),
			'Match Passwords' => array(
				'rule' => 'matchPasswords',
				'message' => 'Passwords do not match.',
			)
		),
		'password_confirmation' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				'message' => 'Please enter a password.',
			),
		),
	);

	public function matchPasswords($data){
		if ($data['password'] == $this->data['User']['password_confirmation']) {
			return true;
		}
		$this->invalidate('password_confirmation', 'Passwords do not match.');
		return false;
	}

	public function beforeSave($options = Array()){
		if (isset($this->data['User']['password'])) {
			$this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
		}
		return true;
	}

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
