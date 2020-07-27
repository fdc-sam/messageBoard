<?php

App::uses('Controller', 'Controller');

class AppController extends Controller {

	public $helpers = array('Js');
	public $components = array(
		'Flash','RequestHandler',
		'Auth'=>array(
			'loginRedirect'=>'messenger',
			'logoutRedirect'=>'login',
			'authError'=>"You can't access that page",
			'autorize'=>array('Contoller')
		)
	);

	function isAuthorized($user) { return true; }

	public function beforeFilter(){
		$this->Auth->allow('index', 'view', 'register');
		$this->set('logged_in', $this->Auth->loggedIn());
		$this->set('current_user', $this->Auth->user());
		$this->set('base_url', $this->webroot);
		
	}
}
