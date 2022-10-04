<?php

namespace application\models;

use application\core\Model;

class Balance extends Model {

	public $error;
	
	public function isPackageExists($id){
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM packages WHERE id = :id', $params);
	}

	public function getPackage($package,$email){
		$params = [
			'id' => '0',
			'email' => $email,
			'package' => 'default',
			'offers' => 7,
			'date' => date("Y-m-d H:i"),
			'date_end' => NULL
		];
		$this->db->query('INSERT INTO packages VALUES (:id, :email, :package, :offers, :date, :date_end)', $params);
	}

	public function countOffers($email){
		$params = ['email' => $email];
		return $this->db->column('SELECT offers FROM packages WHERE email = :email', $params);
	}

	public function subtractOffer($email){
		$params = ['email' => $email];
		$this->db->query('UPDATE packages SET offers = offers - 1 WHERE email = :email', $params);
	}

	public function appendOffer($email){
		$params = ['email' => $email];
		$this->db->query('UPDATE packages SET offers = offers + 1 WHERE email = :email', $params);
	}

	public function getPackageUser($email){
		$params = ['email'=>$email];
		return $this->db->column('SELECT package FROM packages WHERE email = :email', $params);
	}

	public function balanceOffers($count, $email){
		$params = [
			'email' => $email,
			'offers' => $count
		];
		$this->db->query('UPDATE packages SET offers = :offers WHERE email = :email', $params);
	}

	public function datePackage(){
		$params = ['email' => $_SESSION['user']['email']];

		$pack = $this->db->column('SELECT date_end FROM packages WHERE email = :email', $params);
		if ($pack == NULL ) {$pack = date("Y-m-d H:i", strtotime('+ 7 days'));}
		return $pack;
		

	}

	public function dateUserPackage($email){
		$params = [
			'email' => $email
		];
		$pack = $this->db->column('SELECT date_end FROM packages WHERE email = :email', $params);
		if ($pack == NULL ) {$pack = date("Y-m-d H:i", strtotime('+ 7 days'));}
		return $pack;
		

	}

	public function setPackage($package,$email, $newpackage){
		$date = date("Y-m-d H:i");

		$date_end = date("Y-m-d H:i", strtotime($_POST['date_end'].'hours'));

		// $params = [
		// 	'email' => $email,
		// 	'offers' => ,
		// 	'date' => ,
		// 	'date_end' => 
		// ];
		// $this->db->query('UPDATE packages SET offers = :offers, date = :date, date_end = :date_end WHERE email = :email', $params);
	}
	
}