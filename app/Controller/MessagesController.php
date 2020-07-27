<?php

App::uses('AppController', 'Controller');


class MessagesController extends AppController {

	public function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('getMessages','sendMessage');
	}

	public function sendMessage(){
		$this->autoRender = false;

		$this->request->data['to_id'] = $this->request->data['friendId'];
		$this->request->data['from_id'] = $this->Auth->user('id');;
		$this->request->data['created'] = date('Y-m-d H:i');

		if ($this->request->is('post')) {
			if ($this->Message->save($this->request->data)) {
				// $this->Flash->set('The user been saved');
				echo "messageSend";
			}else{
				// $this->Flash->set('The user could not be save. Please try again');
				echo "messageNotSend";
			}
		}
	}

	public function getMessages(){
		$this->autoRender = false;
		$friendId = $this->request->data['friendId'];
		$myId = $this->Auth->user('id');

		$conditions = array(
			'OR' => array(
				array('AND' => array(
					array('to_id' => $friendId),
					array('from_id' => $myId)
				)),
				array('AND' => array(
					array('to_id' => $myId),
					array('from_id' => $friendId)
				)
			))
		);
		$result = $this->Message->find('all', array(
			'conditions' => $conditions
		));

		$data = array();
		foreach ($result as $key => $value) {
			// gettin the time
			$messageCreated = date('m/d/Y', strtotime($value['Message']['modified']));
			$temp = self::formatTimeString($messageCreated);

			if ($value['Message']['from_id'] == $myId) {
				$message = '<div class="outgoing_msg">
					<div class="sent_msg">
						<p>'.$value['Message']['content'].'</p>
						<span class="time_date">    |    '.$temp.'</span> </div>
				</div>';
			}else{
				$message = '<div class="incoming_msg">
					<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
					<div class="received_msg">
						<div class="received_withd_msg">
							<p>'.$value['Message']['content'].'</p>
							<span class="time_date">     |    '.$temp.'</span></div>
					</div>
				</div>';
			}
			array_push($data, $message);
		}
		// echo date('m/d/Y', strtotime('1299446702'));
		// print_r($data);
		echo json_encode($data);
	}

	function formatTimeString($timeStamp) {
		$str_time =$timeStamp;
		$time = strtotime($str_time);
		$d = new DateTime($str_time);

		$weekDays = ['Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'];
		$months = ['Jan', 'Feb', 'Mar', 'Apr', ' May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

		if ($time > strtotime('-2 minutes')) {
			return 'Just now';
		} elseif ($time > strtotime('-59 minutes')) {
			$min_diff = floor((strtotime('now') - $time) / 60);
			return $min_diff . ' min' . (($min_diff != 1) ? "s" : "") . ' ago';
		} elseif ($time > strtotime('-23 hours')) {
			$hour_diff = floor((strtotime('now') - $time) / (60 * 60));
			return $hour_diff . ' hour' . (($hour_diff != 1) ? "s" : "") . ' ago';
		} elseif ($time > strtotime('today')) {
			return $d->format('G:i');
		} elseif ($time > strtotime('yesterday')) {
			return 'Yesterday at ' . $d->format('G:i');
		} elseif ($time > strtotime('this week')) {
			return $weekDays[$d->format('N') - 1] . ' at ' . $d->format('G:i');
		} else {
			return $d->format('j') . ' ' . $months[$d->format('n') - 1] .
		(($d->format('Y') != date("Y")) ? $d->format(' Y') : "") .
		' at ' . $d->format('G:i');
		}
	}

}
