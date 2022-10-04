<?php

namespace application\models;

use application\core\Model;

class Company extends Model {

	public $error;

	public function isCompanyExists($id) {
		$role = 'company';
		$params = [
			'id' => $id,
			'role' => $role,
		];
		return $this->db->column('SELECT id FROM users WHERE id = :id AND role = :role', $params);
	}

	public function companyData($id) {
		$role = 'company';
		$params = [
			'id' => $id,
			'role' => $role,
		];
		return $this->db->row('SELECT * FROM users WHERE id = :id AND role = :role', $params);
	}

	public function myAdvertsList($route) {
		$email = $_SESSION['user']['email'];
		$type = 'advert';
		$params = [
			'email' => $email,
			'type' => $type
		];
		return $this->db->row('SELECT * FROM offers WHERE email = :email AND type = :type', $params);
	}




}