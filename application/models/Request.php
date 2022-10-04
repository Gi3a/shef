<?php

namespace application\models;

use application\core\Model;


class Request extends Model {

	public $error;

	public function validate($input, $post){
		$rules = [
			'email' => [
				'pattern' => '#^([A-z0-9_.-]{1,20}+)@([A-z0-9_.-]+)\.([a-z\.]{2,10})$#',
				'message' => 'E-mail адрес указано неверно',
			],
			'description' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-z0-9_.,! -]{2,512}$#u',
				'message' => 'Описание указано неверно (от 2 до 512 символов)',
			],
			'cost' => [
				'pattern' => '#^[0-9]{1,40}$#',
				'message' => 'Цена указана неверно (от 1 до 40 символов)',
			],
			'address' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-Z0-9 , -]{2,250}$#u',
				'message' => 'Название адреса указано неверно (от 2 до 250 символов)',
			],
			'keywords' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-Z0-9, ]{2,250}$#u',
				'message' => 'Ключевые слова указаны неверно',
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

	public function checkPromocode($code){
		$params = ['code' => $code];
		return $this->db->column('SELECT id FROM actions WHERE code = :code',$params);
	}

	public function offerEmail($id){
		$params = ['id' => $id];
		return $this->db->row('SELECT email FROM offers WHERE id = :id', $params);
	}

	public function checkBasket($offer_customer,$offer_email){
		$params = ['offer_customer' => $offer_customer, 'offer_email' => $offer_email];
		return $this->db->column('SELECT id FROM requests WHERE offer_email = :offer_email AND offer_customer = :offer_customer', $params);
	}

	public function requestAdd($post, $offer_email, $offer_customer){
		if (!empty($post['promocode'])) {$promocode = $post['promocode'];}
		else{$promocode = null;}
		$params = [
			'id' => '0',
			'address' => $post['address'],
			'promocode' => $promocode,
			'pay' => $post['pay'],
			'delivery' => $post['delivery'],
			'time_delivery' => $post['time_delivery'],
			'date' => date("Y-m-d H:i"),
			'offer_email' => $offer_email,
			'offer_customer' => $offer_customer,
			'status' => 'not sent'
		];
		$this->db->query('INSERT INTO requests VALUES (:id, :address, :promocode, :pay, :delivery, :time_delivery, :date, :offer_email, :offer_customer, :status)', $params);
		return $this->db->lastInsertId();
	}

	public function requestOfferAdd($offer_request,$offer_id,$count,$description){
		$params = [
			'id' => '0',
			'offer_request' => $offer_request,
			'offer_id' => $offer_id,
			'count' => $count,
			'description' => $description,
		];
		$this->db->query('INSERT INTO requests_offer VALUES (:id, :offer_request, :offer_id, :count, :description)', $params);
	}


	public function requestCount(){
		$params = ['offer_email' => $_SESSION['user']['email']];
		return $this->db->column('SELECT COUNT(id) FROM request WHERE offer_email = :offer_email', $params);
	}

	public function responseCount(){
		$params = ['offer_customer' => $_SESSION['user']['email']];
		return $this->db->column('SELECT COUNT(id) FROM request WHERE offer_customer = :offer_customer', $params);
	}

	public function requestList($route){
		$max = 3;
		$params = [
			'offer_email' => $_SESSION['user']['email'],
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM requests WHERE offer_email = :offer_email ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function responseList($route){
		$max = 3;
		$params = [
			'offer_customer' => $_SESSION['user']['email'],
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM requests WHERE offer_customer = :offer_customer ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function requestAccept($id){
		$params = ['id' => $id, 'offer_email' => $_SESSION['user']['email'], 'status' => 'do'];
		$this->db->query('UPDATE requests SET status = :status WHERE id = :id AND offer_email = :offer_email' ,$params);
	}

	public function requestOffer($id){
		$params = ['id' => $id];
		return $this->db->row('SELECT offer_customer,offer_id FROM request WHERE id = :id',$params);
	}

	public function requestDecline($id){
		$params = ['id' => $id, 'offer_email' => $_SESSION['user']['email'], 'status' => 'do'];
		$this->db->query('DELETE FROM request WHERE (id = :id) AND ((offer_email = :offer_email)OR (offer_customer = :offer_email))' ,$params);
	}

	public function requestView($id){
		$params = ['id' => $id];
		return $this->db->row('SELECT * FROM requests WHERE id = :id',$params);
	}

	public function requestOffersId($id){
		$params = ['id' => $id];
		return $this->db->row('SELECT offer_id FROM requests_offer WHERE offer_request = :id',$params);
	}

	public function requestOffersCount($offers){
		return count($offers);
	}

	public function requestOffers($offers,$route){
		$str = '';
		for($i = 0;$i <= count($offers)-1; $i++){$str .= ($offers[$i]['offer_id']. ',');}
		$str = (substr($str, 0, -1));
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM offers WHERE id IN ('.$str.') ORDER BY id DESC LIMIT :start, :max', $params);
	}

	

}