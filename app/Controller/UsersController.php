<?php

App::uses('AppController', 'Controller');
class UsersController extends AppController {

	public $name = 'Users';

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login','register', 'logout');
	}

	public function index() {
		// echo $this->Auth->user('username');
		// if ($this->request->is('post')) {
		// 	// echo "string";
		// 	// debug($this->Auth->login($this->data)); die();
		// 	if ($this->Auth->login()) {
		// 		$this->redirect('index');
		// 	}else{
		// 		$this->redirect($this->Auth->redirect());
		// 		$this->Flash->set('Your username/password combination is incorrect');
		// 	}
		// }
	}

	public function login(){
		$path = func_get_args();
		$this->set('path', $path);
		// print_r($path);
		// die();
		if ($this->Auth->user('id') != null) {
			$this->redirect($this->Auth->redirect());
		}else{
			if($this->request->is('post')&&!empty($this->request->data)) {
	      App::Import('Utility', 'Validation');

	      if( isset($this->data['User']['username']) && Validation::email($this->request->data['User']['username'])) {
	        $this->request->data['User']['email'] = $this->request->data['User']['username'];
	        $this->Auth->authenticate['Form'] = array('fields' => array('username' => 'email'));
	      }

	      if($this->Auth->login()) {
	        $this->redirect($this->Auth->redirect()); /* login successful */
	      } else {
	        /* login unsuccessful */
					$this->Flash->set('The user could not be save. Please try again');
	      }
	    }
		}
	}

	public function logout(){
		$path = func_get_args();
		$this->set('path', $path);
		$this->redirect($this->Auth->logout());
	}

	public function register(){
		$path = func_get_args();
		$this->set('path', $path);
		if ($this->request->is('post')) {

			$this->request->data['User']['created_ip'] = $this->RequestHandler->getClientIp();
			$this->request->data['User']['username'] = $this->request->data['User']['email'];

			if ($this->User->save($this->request->data)) {
				$this->Flash->set('The user been saved');
				if($this->Auth->login()) {
	        /* login successful */
	        $this->redirect($this->Auth->redirect());
	      } else {
	        /* login unsuccessful */
					$this->Flash->set('The user could not be save. Please try again');
	      }
			}else{
				$this->Flash->set('The user could not be save. Please try again');
			}
		}
	}

	public function messenger(){
		$path = func_get_args();
		$this->set('path', $path);
	}

	// select2 search
	public function getData(){
		$this->autoRender = false;
		$keyword = $this->request->data['searchTerm'];
		// $list =	$this->User->query("SELECT users.id, users.email as text FROM users WHERE email LIKE '%$keyword%' LIMIT 10;");
		$conditions = array("email LIKE" => "%$keyword%");
		$list = $this->User->find('all', array(
			'conditions' => $conditions,
			'fields' => array('id', 'email as text')
		));

		$email = array();
		foreach ($list as $key => $value) {
			if ($this->Auth->user('id') == $value['User']['id']) {
				//get the current user id
			}else{
				array_push($email,$value['User']);
			}
		}
		// print_r($email);
		// die();
		echo json_encode($email);
		// echo "<pre>";
		// print_r($email);
		// die();

	}

}
