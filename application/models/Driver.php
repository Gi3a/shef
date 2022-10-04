<?php

namespace application\models;

use application\core\Model;

class Driver extends Model {

	public $error;

	public function isDriverExists($id) {
		$params = ['id' => $id,'role' => 'driver',];
		return $this->db->column('SELECT id FROM users WHERE id = :id AND role = :role', $params);
	}

	public function driverData($id) {
		$params = ['id' => $id,'role' => 'driver',];
		return $this->db->row('SELECT * FROM users WHERE id = :id AND role = :role', $params);
	}

	public function routesCount($route){
		$params = ['status' => 'search'];
		return $this->db->column('SELECT COUNT(id) FROM routes WHERE status = :status', $params);
	}

	public function routesList($route) {
		$max = 3;
		$params = [
			'status' => 'search',
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM routes WHERE status = :status ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function myRoutesCount($route){
		$params = ['executor_email' => $_SESSION['user']['email'],'status' => 'done'];
		return $this->db->column('SELECT COUNT(id) FROM routes WHERE executor_email = :executor_email AND status != :status', $params);
	}


	public function myRoutesList($route) {
		$max = 3;
		$params = [
			'executor_email' => $_SESSION['user']['email'],
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
			'status' => 'done'
		];
		return $this->db->row('SELECT * FROM routes WHERE executor_email = :executor_email AND status != :status ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function isRouteExists($id){
		$params = ['id' => $id,];
		return $this->db->column('SELECT id FROM routes WHERE id = :id', $params);
	}

	public function routeData($id){
		$params = ['id' => $id,];
		return $this->db->row('SELECT * FROM routes WHERE id = :id', $params);
	}

	public function routeConfirm($id){
		$params = [
			'id' => $id,
			'executor_email' => $_SESSION['user']['email'],
			'status' => 'do',
			'date_accept' => date("Y-m-d H:i"),
		];
		$this->db->query('UPDATE routes SET executor_email = :executor_email, status = :status, date_accept = :date_accept WHERE id = :id', $params);
	}

	public function clientEmail($id){
		$params = ['id' => $id];
		return $this->db->column('SELECT client_email FROM routes WHERE id = :id', $params);
	}

	public function beforeAccept($data){
		$date = date("Y-m-d H:i");
		$date_create = $data['date_accept'];
		$date_back = date("Y-m-d H:i", strtotime($date_create . '15 minutes'));
		if ($date <= $date_back) {return true;}
		return false;
	}

	public function routeDone($id){
		$params = [
			'id' => $id,
			'executor_email' => $_SESSION['user']['email'],
			'status' => 'done',
		];
		$this->db->query('UPDATE routes SET executor_email = :executor_email, status = :status WHERE id = :id', $params);
	}

	public function routeTake($id){
		$params = [
			'id' => $id,
			'executor_email' => $_SESSION['user']['email'],
			'status' => 'take',
		];
		$this->db->query('UPDATE routes SET executor_email = :executor_email, status = :status WHERE id = :id', $params);
	}

	public function routeGive($id){
		$params = [
			'id' => $id,
			'executor_email' => $_SESSION['user']['email'],
			'status' => 'give',
		];
		$this->db->query('UPDATE routes SET executor_email = :executor_email, status = :status WHERE id = :id', $params);
	}

	public function routeCancel($id){
		$params = [
			'id' => $id,
			'executor_email' => NULL,
			'status' => 'search',
		];
		$this->db->query('UPDATE routes SET executor_email = :executor_email, status = :status WHERE id = :id', $params);
	}

	public function routePaid($id){
		$params = ['id' => $id,'executor_email' => $_SESSION['user']['email'],];
		$this->db->query('DELETE FROM routes WHERE id = :id AND executor_email = :executor_email', $params);
	}

	public function myExecutedCount(){
		$params = ['executor_email' => $_SESSION['user']['email'],'status' => 'done'];
		return $this->db->column('SELECT COUNT(id) FROM routes WHERE executor_email = :executor_email AND status = :status', $params);
	}

	public function myExecutedList(){
		$max = 3;
		$params = [
			'executor_email' => $_SESSION['user']['email'],
			'status' => 'done',
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM routes WHERE executor_email = :executor_email AND status = :status ORDER BY id DESC LIMIT :start, :max', $params);
	}


	public function isExecuteExists($id){
		$params = ['id' => $id,'status'=>'done'];
		return $this->db->column('SELECT id FROM routes WHERE id = :id AND status = :status', $params);
	}

	public function executeData($id){
		$params = ['id' => $id,'status'=>'done'];
		return $this->db->row('SELECT * FROM routes WHERE id = :id AND status = :status', $params);
	}
}