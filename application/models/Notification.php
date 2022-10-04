<?php

namespace application\models;

use application\core\Model;


class Notification extends Model {

	public $error;

	public function isNotificationExists($id) {
		$params = [
			'id' => $id
		];
		return $this->db->column('SELECT id FROM notifications WHERE id = :id', $params);
	}

	public function notificationsCount(){
		$email = $_SESSION['user']['email'];
		$params = [
			'email' => $email,
		];
		return $this->db->column('SELECT COUNT(id) FROM notifications WHERE email = :email', $params);
	}

	public function successNotification($email,$text,$offer, $route){
		$params = [
			'id' => '0',
			'type' => 'success',
			'email' => $email,
			'description' => $text,
			'date' => date("Y-m-d H:i"),
			'offer' => $offer,
			'route' => $route,
		];
		$this->db->query('INSERT INTO notifications VALUES (:id, :type, :email, :description, :date, :offer, :route)', $params);
		return $this->db->lastInsertId();
	}

	public function defaultNotification($email,$text,$offer, $route){
		$type = 'default';
		$date = date("Y-m-d H:i");
		$params = [
			'id' => '0',
			'type' => $type,
			'email' => $email,
			'description' => $text,
			'date' => $date,
			'offer' => $offer,
			'route' => $route,
		];
		$this->db->query('INSERT INTO notifications VALUES (:id, :type, :email, :description, :date, :offer, :route)', $params);
		return $this->db->lastInsertId();
	}

	public function errorNotification($email,$text,$offer, $route){
		$type = 'error';
		$date = date("Y-m-d H:i");
		$params = [
			'id' => '0',
			'type' => $type,
			'email' => $email,
			'description' => $text,
			'date' => $date,
			'offer' => $offer,
			'route' => $route,
		];
		$this->db->query('INSERT INTO notifications VALUES (:id, :type, :email, :description, :date, :offer, :route)', $params);
		return $this->db->lastInsertId();
	}

	public function statusNotifications($email,$type, $offer, $route){
		$params = [
			'email' => $email,
			'type' => $type,
			'offer' => $offer,
			'route' => $route,
		];
		$this->db->query('DELETE FROM notifications WHERE ((email = :email) AND (type = :type) AND ((offer = :offer) OR (route = :route)))', $params);
	}

	public function notificationsList($route){
		$email = $_SESSION['user']['email'];
		$max = 3;
		$params = [
			'email' => $email,
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM notifications WHERE email = :email ORDER BY date DESC LIMIT :start, :max', $params);
	}

	public function delete($route){
		$id = $route['id'];
		$controller = $route['controller'];
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM notifications WHERE id = :id', $params);
		return $controller;
	}


}