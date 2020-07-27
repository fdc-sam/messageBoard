<?php

App::uses('AppController', 'Controller');
class FriendsController extends AppController {
	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('addContact','getContact');
	}

	//add contacts
	public function addContact(){
		$this->autoRender = false;
		//information abount the current user and the user that he/she add
		$data = $this->request->data;
		$userId = $data['userId'];
		$friendId = $data['id'];
		print_r($userId.', '.$friendId.PHP_EOL);
		//verify the imformation query
		$conditions = array('AND' => array(
			array('user_id' => $friendId),
			array('my_id' => $userId)
		));

		$result = $this->Friend->find('count', array(
			'conditions' => $conditions
		));
		// print_r($result);
		// die();
		if ($result >= 1) {
			print_r($result);
		}else{
			$dataFriend = array("user_id" => $friendId, "my_id" => $userId);
			$this->Friend->save($dataFriend);
		}
	}

	// get the contacts
	public function getContact($limit = null){
		$this->autoRender = false;
		$dataLimit = 10;
		if (is_null($limit)) {
			$limit = 0;
			$dataLimit = $dataLimit + $limit;
		}else{
			$dataLimit = $dataLimit + $limit;
		}
		// print_r($this->request->data['contactLoadLimit']);
		$userId = $this->Auth->user('id'); // current user
		$offset = $dataLimit - 10;
		$conditions = array('OR' => array(
			array("my_id" => $userId),
			array("user_id" => $userId),
		));
		$result = $this->Friend->find('all', array('conditions' => $conditions,
			'limit' => $dataLimit,
			'offset' => $offset,
		));

		$data = array();
		foreach ($result as $key => $value) {
			array_push($data, $value['User']);
		}

		$dataReturn = '';
		$i = 0;
		$contactUsers = array();
		foreach ($data as $key => $view) {
			if ($view['id'] != $userId) {
				$dataReturn = '<div class="chat_list" friendId ="'.$view['id'].'">'.$view['id'].'
						<div class="chat_people">
							<div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
								<div class="chat_ib">
									<h5> '.$view['name'].' <span class="chat_date"></span></h5>
									<p>'.$view['hobby'].'</p>
							</div>
						</div>
					</div>';
				array_push($contactUsers, $dataReturn);
			}
		}
		echo json_encode($contactUsers);
	}


}
