<?php

namespace application\models;

use application\core\Model;


class Offer extends Model {

	public $error;

	public function isOfferExists($id){
		$params = ['id' => $id];
		return $this->db->column('SELECT id FROM offers WHERE id = :id', $params);
	}

	public function offerData($id){
		$params = ['id' => $id];
		return $this->db->row('SELECT * FROM offers WHERE id = :id', $params);
	}

	public function offerPriority($id){
		$params = ['id' => $id];
		return $this->db->column('SELECT priority FROM offers WHERE id = :id', $params);
	}


	// Order's Model

	public function orderListInfo($id){
		$params = ['id' => $id];
		return $this->db->row('SELECT * FROM orders_list WHERE id = :id', $params);
	}

	public function orderStatus($email,$offer,$email_executor){
		$params = [
			'offer' => $offer,
			'email' => $email,
			'email_executor' => $email_executor,
		];
		return $this->db->column('SELECT id FROM orders_list WHERE offer = :offer AND email = :email AND email_executor = :email_executor', $params);
	}

	public function orderExecutorStatus($offer){
		$params = ['offer' => $offer];
		return $this->db->row('SELECT * FROM orders_executor WHERE offer = :offer',$params);

	}

	public function update($id,$post){
		$date = date("Y-m-d H:i");
		$date_end = date("Y-m-d H:i", strtotime($_POST['date_end'].'hours'));
		$params = [
			'id' => $id,
			'description' => $post['description'],
			'cost' => $post['cost'],
			'route' => $post['route'],
			'date' => $date,
			'date_end' => $date_end
		];
		$this->db->query('UPDATE orders_list SET description = :description, cost = :cost, route = :route, date = :date, date_end = :date_end WHERE id = :id', $params);
	}

	public function make($post,$email,$offer,$email_executor){
		$date = date("Y-m-d H:i");
		$date_end = date("Y-m-d H:i", strtotime($_POST['date_end'].'hours'));
		$params = [
			'id' => '0',
			'description' => $post['description'],
			'cost' => $post['cost'],
			'route' => $post['route'],
			'email' => $email,
			'offer'=> $offer,
			'email_executor' => $email_executor,
			'date' => $date,
			'date_end' => $date_end
		];
		$this->db->query('INSERT INTO orders_list VALUES (:id, :description, :cost, :route, :email, :offer, :email_executor, :date, :date_end)', $params);
	}

	public function countExecutors($offer){
		$params = ['offer'=>$offer];
		return $this->db->column('SELECT COUNT(id) FROM orders_list WHERE offer = :offer',$params);
	}

	public function listExecutors($offer){
		$params = ['offer'=>$offer];
		return $this->db->row('SELECT * FROM orders_list WHERE offer = :offer',$params);
	}

	public function suggestionData($offer,$email_executor){
		$params = ['offer'=>$offer, 'email_executor' => $email_executor];
		return $this->db->row('SELECT * FROM orders_list WHERE (offer = :offer) AND (email_executor = :email_executor)',$params);
	}

	public function mySuggestion($offer,$email_executor){
		$params = ['offer'=>$offer, 'email_executor' => $email_executor];
		return $this->db->column('SELECT id FROM orders_list WHERE (offer = :offer) AND (email_executor = :email_executor)',$params);
	}

	public function unmake($offer,$email_executor){
		$params = ['offer' => $offer, 'email_executor' => $email_executor];
		$this->db->query('DELETE FROM orders_list WHERE offer = :offer AND email_executor = :email_executor',$params);
	}

	public function apply($data){
		$date = date("Y-m-d H:i");
		$date_end = date("Y-m-d H:i", strtotime(3 .'hours'));
		$params = [
			'id' => '0',
			'description' => $data[0]['description'],
			'cost' => $data[0]['cost'],
			'route' => $data[0]['route'],
			'email' => $data[0]['email'],
			'offer' => $data[0]['offer'],
			'email_executor' => $data[0]['email_executor'],
			'status' => 'do',
			'date' => $date,
			'date_end' => $date_end
		];
		$this->db->query('INSERT INTO orders_executor VALUES (:id, :description, :cost, :route, :email, :offer, :email_executor, :status, :date, :date_end)',$params);
	}

	public function afterApply($offer){
		$params = ['offer' => $offer];
		$this->db->query('DELETE FROM orders_list WHERE offer = :offer',$params);
	}

	public function orderExecutor($offer,$email){
		$params = ['offer' => $offer, 'email' => $email];
		return $this->db->row('SELECT * FROM orders_executor WHERE offer = :offer AND ((email = :email) OR (email_executor = :email))', $params);
	}

	public function ready($data){
		$params = ['offer' => $data[0]['offer'], 'email_executor' => $data[0]['email_executor'], 'status' => 'ready'];
		$this->db->query('UPDATE orders_executor SET status = :status WHERE offer = :offer AND email_executor = :email_executor', $params);
	}

	public function cancel($data){
		$params = ['offer' => $data[0]['offer'], 'email_executor' => $data[0]['email_executor'],];
		$this->db->query('DELETE FROM orders_executor WHERE offer = :offer AND email_executor = :email_executor', $params);
	}

	public function beforeRefuse($data){
		$date = date("Y-m-d H:i");
		$date_create = $data[0]['date'];
		$date_back = date("Y-m-d H:i", strtotime($date_create . '30 minutes'));
		if ($date <= $date_back) {
			return true;
		}
		return false;
	}

	public function refuse($data,$email){
		$params = ['offer' => $data[0]['offer'],];
		$this->db->query('DELETE FROM orders_executor WHERE offer = :offer',$params);
	}

	public function done($data,$email){
		$params = ['offer' => $data[0]['offer'],];
		$this->db->query('DELETE FROM orders_executor WHERE offer = :offer',$params);
	}

	public function checkOwnOrder($offer,$email){
		$params = ['offer' => $offer, 'email' => $email];
		$id = $this->db->column('SELECT id FROM orders_list WHERE offer = :offer AND email = :email', $params);
		if ((!empty($id)) AND ($id != 0)) {
			return true;
		}
		return false;
	}

	public function checkOwnOrderExecutor($offer,$email){
		$params = ['offer' => $offer, 'email' => $email];
		$id = $this->db->column('SELECT id FROM orders_executor WHERE offer = :offer AND email = :email', $params);
		if ((!empty($id)) AND ($id != 0)) {
			return true;
		}
		return false;
	}

	public function checkOrderExecutor($offer,$email_executor){
		$params = ['offer' => $offer, 'email_executor' => $email_executor];
		$id = $this->db->column('SELECT id FROM orders_executor WHERE offer = :offer AND email_executor = :email_executor', $params);
		if ((!empty($id)) AND ($id != 0)) {
			return true;
		}
		return false;
	}


}