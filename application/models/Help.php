<?php

namespace application\models;

use application\core\Model;


class Help extends Model {

	public $error;

	public function validate($input,$post){
		$rules = [
			'email' => [
				'pattern' => '#^([A-z0-9_.-]{1,20}+)@([A-z0-9_.-]+)\.([a-z\.]{2,10})$#',
				'message' => 'E-mail адрес указано неверно',
			],
			'title' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-Z0-9_.,! -]{2,250}$#u',
				'message' => 'Название указано неверно (от 2 до 250 символов)',
			],
			'description' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-z0-9_.,! -]{2,512}$#u',
				'message' => 'Описание указано неверно (от 2 до 512 символов)',
			]
		];
		foreach ($input as $val) {
			if (!isset($post[$val]) or !preg_match($rules[$val]['pattern'], $post[$val])) {
				$this->error = $rules[$val]['message'];
				return false;
			}
		}
		return true;
	}

	public function messageAdd($post){
		$date = date("Y-m-d H:i");

		$params = [
			'id' => '0',
			'type' => $post['type'],
			'email' => $post['email'],
			'title' => $post['title'],
			'description' => $post['description'],
			'date' => $date,
		];
		$this->db->query('INSERT INTO contacts VALUES (:id, :type, :email, :title, :description, :date)', $params);
	}

}