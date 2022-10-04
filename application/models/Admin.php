<?php

namespace application\models;

use application\core\Model;

class Admin extends Model {

	public $error;

	public function validate($input, $post){
		$rules = [
			'email' => [
				'pattern' => '#^([A-z0-9_.-]{1,20}+)@([A-z0-9_.-]+)\.([a-z\.]{2,10})$#',
				'message' => 'E-mail адрес указано неверно',
			],
			'name' => [
				'pattern' => '#^[A-z0-9]{2,50}$#',
				'message' => 'Имя указано неверно (от 2 до 50 символов)',
			],
			'phone' => [
				'pattern' => '#^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$#',
				'message' => 'Номер телефона указан не верно',
			],
			'password' => [
				'pattern' => '#^[A-z0-9]{8,40}$#',
				'message' => 'Пароль указан неверно (разрешены только латинские буквы и цифры от 8 до 40 символов',
			],

		];

		foreach ($input as $val) {
			if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
				$this->error = $rules[$val]['message'];
				return false;
			}
		}
		return true;
	}

	public function offerEmail($id){
		$params = ['id' => $id];
		return $this->db->column('SELECT email FROM offers WHERE id = :id', $params);
	}

	public function checkData($email,$password){
		$params = [
			'email' => $email,
		];

		$hash = $this->db->column('SELECT password FROM admins WHERE email = :email', $params);
		if (!$hash or !password_verify($password, $hash)) {
		 	return false;
		} 
		return true;
	}

	public function login($email){
		$params = [
			'email' => $email,
		];
		$data = $this->db->row('SELECT * FROM admins WHERE email = :email', $params);
		$_SESSION['admin'] = $data[0];
	}

	public function adminsCount($route){
		$action = $route['action'];
		$action = substr($action, 0, -1);
		$params = [
			'action' => $action
		];
		return $this->db->column('SELECT COUNT(id) FROM admins WHERE role = :action', $params);
	}

	public function adminsList($route){
		$action = $route['action'];
		$action = substr($action, 0, -1);
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
			'action' => $action
		];
		return $this->db->row('SELECT * FROM admins WHERE role = :action ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function contactCount(){
		return $this->db->column('SELECT COUNT(id) FROM contacts');
	}

	public function contactList(){
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM contacts ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function isContactExists($id){
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM contacts WHERE id = :id', $params);
	}

	public function contactData($id){
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM contacts WHERE id = :id', $params);
	}

	public function uncontact($id){
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM contacts WHERE id = :id', $params);
	}

	public function isAdminExsist($id){
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM admins WHERE id = :id', $params);
	}

	public function isUserExsist($id){
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM users WHERE id = :id', $params);
	}


	public function adminData(){
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM admins WHERE id = :id', $params);
	}

	public function view($id){
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM admins WHERE id = :id', $params);
	}

	public function memberDelete($id){
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM admins WHERE id = :id', $params);
	}

	public function generateToken(){
		return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 10)), 0, 10);
	}

	public function userPause($id){
		$token = $this->generateToken();
		$status = 0;
		$params = [
			'id' => $id,
			'status' => $status
		];
		$this->db->query('UPDATE users SET status = :status, token = :token WHERE id = :id', $params);
	}

	public function userActivate($id){
		$status = 1;
		$params = [
			'id' => $id,
			'status' => $status
		];
		$this->db->query('UPDATE users SET status = :status, token = "" WHERE id = :id', $params);
	}

	public function userClean($id){
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM users WHERE id = :id', $params);
	}

	public function usersList($route){
		$action = $route['action'];
		$action = substr($action, 0, -1);
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
			'action' => $action
		];
		return $this->db->row('SELECT * FROM users WHERE role = :action ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function usersCount($route){
		$action = $route['action'];
		$action = substr($action, 0, -1);
		$params = [
			'action' => $action
		];
		return $this->db->column('SELECT COUNT(id) FROM users WHERE role = :action', $params);
	}


	public function offersCount($route) {
		if (substr($route['action'], 0, 6) == 'advert') {$type = 'advert';}
		elseif(substr($route['action'], 0, 5) == 'order'){$type = 'order';}
		$params = [
			'type' => $type
		];
		return $this->db->column('SELECT COUNT(id) FROM offers WHERE type = :type', $params);
	}

	public function offersList($route) {
		if (substr($route['action'], 0, 6) == 'advert') {$type = 'advert';}
		elseif(substr($route['action'], 0, 5) == 'order'){$type = 'order';}
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
			'type' => $type
		];
		return $this->db->row('SELECT * FROM offers WHERE type = :type ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function routesCount($route){
		return $this->db->column('SELECT COUNT(id) FROM routes');
	}

	public function routesList($route) {
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM routes ORDER BY id DESC LIMIT :start, :max', $params);
	}
	

}