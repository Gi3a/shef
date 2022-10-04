<?php

namespace application\models;

use application\core\Model;


class User extends Model {

	public $error;

	public function validate($input, $post){
		$rules = [
			'email' => [
				'pattern' => '#^([A-z0-9_.-]{1,20}+)@([A-z0-9_.-]+)\.([a-z\.]{2,10})$#',
				'message' => 'E-mail адрес указано неверно',
			],
			'login' => [
				'pattern' => '#^[a-zA-z0-9._]{3,50}$#',
				'message' => 'Логин указан неверно (разрешены только латинские буквы и цифры от 3 до 50 символов)',
			],
			'name' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-z0-9]{2,50}$#u',
				'message' => 'Имя указано неверно (от 2 до 50 символов)',
			],
			'phone' => [
				'pattern' => '#^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$#',
				'message' => 'Номер телефона указан не верно',
			],
			'password' => [
				'pattern' => '#^[A-z0-9]{8,40}$#',
				'message' => 'Пароль указан неверно (разрешены только латинские буквы и цифры от 8 до 40 символов)',
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
	public function validateOffer($input,$post){
		$rules = [
			'title' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-Z0-9_.,! -]{2,250}$#u',
				'message' => 'Название указано неверно (от 2 до 250 символов)',
			],
			'description' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-z0-9_.,! -]{2,512}$#u',
				'message' => 'Описание указано неверно (от 2 до 512 символов)',
			],
			'cost' => [
				'pattern' => '#^[0-9]{1,40}$#',
				'message' => 'Цена указана неверно (от 1 до 40 символов)',
			],
			'city' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-Z0-9 , -]{2,250}$#u',
				'message' => 'Название города указано неверно (от 2 до 250 символов)',
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

	public function generateToken(){
		return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyz', 10)), 0, 10);
	}

	public function checkUserByLogin($login){
		$params = ['login' => $login];
		return $this->db->column('SELECT id FROM users WHERE login = :login',$params);
	}

	public function getUserByLogin($login){
		$params = ['login' => $login];
		return $this->db->row('SELECT * FROM users WHERE login = :login',$params);
	}


	public function userAdd($post){
		$token = $this->generateToken();
		$package = 'default';
		$photo = '0';
		$enc_password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$date = date("Y-m-d H:i");
		$description = '';

		$params = [
			'id' => '0',
			'email' => $post['email'],
			'login' => $post['login'],
			'photo' => $photo,
			'name' => $post['name'],
			'company' => $post['company'],
			'working_on' => NULL,
			'working_off' => NULL,
			'package' => $package,
			'phone' => $post['phone'],
			'password' => $enc_password,
			'role' => $post['role'],
			'date' => $date,
			'description' => $description,
			'token' => $token,
			'status' => 1,
			'car' => $post['car'],
		];
		$this->db->query('INSERT INTO users VALUES (:id, :email, :login, :photo, :name, :company, :working_on,:working_off, :package, :phone, :password, :role, :date, :description, :token, :status, :car)', $params);
		mail($post['email'], 'Регистрация прошла успешна', 'Подтверждение http://shef/join/confirm/'.$token);
		return $this->db->lastInsertId();
	}

	public function settings($post, $img){
		$working_on_date = $post['working_on_date'];
		$working_on_time = $post['working_on_time'];
		$working_off_date = $post['working_off_date'];
		$working_off_time =  $post['working_off_time'];
		if (empty($post['working_on_date'])) {$working_on_date = NULL;}
		if (empty($post['working_on_time'])) {$working_on_time = NULL;}
		if (empty($post['working_off_date'])) {$working_off_date = NULL;}
		if (empty($post['working_off_time'])) {$working_off_time = NULL;}


		$working_on = date("D-H-i", strtotime($working_on_date.$working_on_time));
		$working_off = date("D-H-i", strtotime($working_off_date.$working_off_time));


		$params = [
			'id' => $_SESSION['user']['id'],
			'email' => $post['email'],
			'login' => $post['login'],
			'photo' => $img,
			'name' => $post['name'],
			'phone' => $post['phone'],
			'description' => $post['description'],
			'working_on' => $working_on,
			'working_off' => $working_off,
		];
		if (!empty($post['password'])) {
			$params['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
			$sql = ',password = :password';
		}
		else{
			$sql = '';
		}
		foreach ($params as $key => $val) {
			$_SESSION['user'][$key] = $val;
		}
		$this->db->query('UPDATE users SET email = :email, login =:login, photo = :photo, name = :name, phone = :phone, description = :description, working_on = :working_on, working_off = :working_off '.$sql.' WHERE id = :id', $params);
	}

	public function recovery($post){
		$token = $this->generateToken();

		$params = [
			'email' => $post['email'],
			'token' => $token,
		];
		$this->db->query('UPDATE users SET token = :token WHERE email = :email', $params);

		mail($post['email'], 'Восстановление пароля', 'Подтверждение http://shef/join/reset/'.$token);
		return $this->db->lastInsertId();
	}

	public function reset($token){
		$password = $this->generateToken();
		$params = [
			'token' => $token,
			'password' => password_hash($password, PASSWORD_BCRYPT),
		];

		$this->db->query('UPDATE users SET status = 1, token = "", password = :password WHERE token = :token', $params);
		return $password;
	}

	public function checkEmailExists($email){
		$params = [
			'email' => $email,
		];
		return $this->db->column('SELECT id FROM users WHERE email = :email', $params);
	}
	public function checkLoginExists($login){
		$params = [
			'login' => $login,
		];
		return $this->db->column('SELECT id FROM users WHERE login = :login', $params);
	}
	public function checkPhoneExists($phone){
		$params = [
			'phone' => $phone,
		];
		return $this->db->column('SELECT id FROM users WHERE phone = :phone', $params);
	}

	public function checkTokenExists($token){
		$params = [
			'token' => $token,
		];
		return $this->db->column('SELECT id FROM users WHERE token = :token', $params);
	}

	public function checkData($email,$password){
		$params = [
			'email' => $email,
			'login' => $email,
			'phone' => $email,
		];

		$hash = $this->db->column('SELECT password FROM users WHERE email = :email OR login = :email OR phone = :phone', $params);
		if (!$hash or !password_verify($password, $hash)) {
		 	return false;
		} 
		return true;
	}

	public function checkStatus($email){
		$params = [
			'email' => $email,
			'login' => $email,
			'phone' => $email,
		];

		$status = $this->db->column('SELECT status FROM users WHERE email = :email OR login = :login OR phone = :phone', $params);
		if ($status != 1) {
			$this->error = 'Подтвердите ваш аккаунт, в письме отправленным на ваш E-mail';
			return false;
		}
		return true;
	}

	public function login($email){
		$params = [
			'email' => $email,
			'login' => $email,
			'phone' => $email,
		];
		$data = $this->db->row('SELECT * FROM users WHERE email = :email OR login = :login or phone = :phone', $params);
		$_SESSION['user'] = $data[0];
	}

	public function activate($token){
		$params = [
			'token' => $token,
		];

		$this->db->query('UPDATE users SET status = 1, token = "" WHERE token = :token', $params);
	}

	public function activateOffer($id,$pack){
		$params = ['id'=>$id,'date_end'=>$pack];
		$this->db->query('UPDATE offers SET date_end = :date_end, status = 1 WHERE id = :id', $params);
	}

	public function deactivateOffer($id,$pack){
		$params = ['id'=>$id,'date_end'=>$pack];
		$this->db->query('UPDATE offers SET date_end = :date_end, status = 0 WHERE id = :id', $params);
	}

	public function isProfileExists($id) {
		$role = 'user';
		$params = [
			'id' => $id,
			'role' => $role
		];
		return $this->db->column('SELECT id FROM users WHERE id = :id AND role = :role', $params);
	}

	public function isUserExists($id) {
		$params = [
			'id' => $id
		];
		return $this->db->column('SELECT id FROM users WHERE id = :id', $params);
	}

	public function isOfferExists($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM offers WHERE id = :id', $params);
	}

	public function profileData($id) {
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM users WHERE id = :id', $params);
	}

	public function getCategory(){
		return $this->db->row('SELECT category FROM categories');
	}

	public function offerAdd($post){
		$date = date("Y-m-d H:i");
		$email = $_SESSION['user']['email'];
		$views = '0';
		$liked = '0';
		$img = 1;

		if ($_POST['date_end'] == 'urgent') {$post_end = 1;$priority=1.5;}
		elseif($_POST['date_end'] == 'common'){$post_end = 7;$priority=1;}
		elseif($_POST['date_end'] == 'monthly'){$post_end = 31;$priority=2;}
		elseif($_POST['date_end'] == 'third'){$post_end = 91;$priority=2;}
		elseif($_POST['date_end'] == 'half'){$post_end = 183;$priority=2;}
		elseif($_POST['date_end'] == 'yearly'){$post_end = 365;$priority=2;}

		if ($post['type'] == 'order') {
			$date_end = date("Y-m-d H:i", strtotime($_POST['date_end'].'hours'));
		}else{
			$date_end = date("Y-m-d H:i", strtotime($post_end.'days'));
		}

		$params = [
			'id' => '0',
			'title' => $post['title'],
			'description' => trim($post['description']),
			'category' => $post['category'],
			'keywords' => $post['keywords'],
			'priority' => $priority,
			'cost' => $post['cost'],
			'views' => $views,
			'photo' => $img,
			'liked' => $liked,
			'date' => $date,
			'date_end' => $date_end,
			'email' => $email,
			'city' => $post['city'],
			'type' => $post['type'],
			'status' => 1
		];

		$this->db->query('INSERT INTO offers VALUES (:id, :title, :description, :category, :keywords, :priority, :cost, :views, :photo, :liked, :date, :date_end, :email, :city, :type, :status)', $params);
		return $this->db->lastInsertId();
	}

	public function offerEdit($post,$id, $img){
		$date = date("Y-m-d H:i");

		$params = [
			'id' => $id,
			'title' => $post['title'],
			'description' => trim($post['description']),
			'category' => $post['category'],
			'cost' => $post['cost'],
			'photo' => $img,
			'city' => $post['city'],
		];
		$this->db->query('UPDATE offers SET title = :title, description = :description, category = :category, cost = :cost,
		photo = :photo, city = :city WHERE id = :id', $params);
	}

	public function imgDeleted($id,$type){
		$photo = 0;
		$params = [
			'id' => $id,
			'photo' => $photo,
		];
		$this->db->query('UPDATE '.$type.' SET photo = :photo WHERE id = :id', $params);
	}

	public function offerData($id){
		$params = [
			'id' => $id,
		];
		return $this->db->row('SELECT * FROM offers WHERE id = :id', $params);
	}

	public function offerDelete($id){
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM offers WHERE id = :id', $params);
	}

	public function userEmail($id){
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT email FROM users WHERE id = :id', $params);
	}

	public function userPackage($email){
		$params = [
			'email' => $email,
		];
		return $this->db->column('SELECT package FROM users WHERE email = :email', $params);
	}


	public function offersList($email){
		$params = [
			'email' => $email,
		];
		return $this->db->row('SELECT * FROM offers WHERE email = :email', $params);
	}

	public function myAdvertsCount(){
		$params = [
			'email' => $_SESSION['user']['email'],
			'type' => 'advert',
		];
		return $this->db->column('SELECT COUNT(id) FROM offers WHERE email = :email AND type = :type', $params);
	}


	public function myAdvertsList($route) {
		$max = 3;
		$params = [
			'email' => $_SESSION['user']['email'],
			'type' => 'advert',
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM offers WHERE email = :email AND type = :type ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function myOrdersCount(){
		$params = [
			'email' => $_SESSION['user']['email'],
			'type' => 'order',
		];
		return $this->db->column('SELECT COUNT(id) FROM offers WHERE email = :email AND type = :type', $params);
	}

	public function myOrdersList($route) {

		$max = 3;
		$params = [
			'email' => $_SESSION['user']['email'],
			'type' => 'order',
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM offers WHERE email = :email AND type = :type ORDER BY id DESC LIMIT :start, :max', $params);
	}

	public function likedId($route) {
		$params = ['user' => $_SESSION['user']['id']];
		return $this->db->row('SELECT offer FROM likes WHERE user = :user', $params);
	}

	public function myLikedListCount($offers){
		return count($offers);
	}

	public function myLikedList($offers,$route){
		$str = '';
		for($i = 0;$i <= count($offers)-1; $i++){$str .= ($offers[$i]['offer']. ',');}
		$str = (substr($str, 0, -1));
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM offers WHERE id IN ('.$str.') ORDER BY id DESC LIMIT :start, :max', $params);
	}




	public function checkUser($id){
		$params = ['id' => $id,];
		$unknownUser = $_SESSION['user']['email'];
		$verifyUser = $this->db->column('SELECT email FROM offers WHERE id = :id', $params);
		
		if ($unknownUser == $verifyUser) {return true;}else{return false;}
		
	}

	public function checkSessionUser($id){
		$params = [
			'id' => $id,
		];
		$unknownUser = $_SESSION['user']['email'];
		$verifyUser = $this->db->column('SELECT email FROM users WHERE id = :id', $params);
		
		if ($unknownUser == $verifyUser) {
			return true;
		}else{
			return false;
		}
	}

	public function conductAction($post){
		if ($post['date_end'] == 'week') {$date_end = 7;}
		elseif($post['date_end'] == 'month'){$date_end = 31;}
		elseif ($post['date_end'] == 'half') {$date_end = 182;}
		$params = [
			'id' => '0',
			'title' => $post['title'],
			'description' => $post['description'],
			'email' => $_SESSION['user']['email'],
			'code' => $post['code'],
			'photo' => 1,
			'city' => $post['city'],
			'views' => 0,
			'date' => date("Y-m-d H:i"),
			'date_end' => date("Y-m-d H:i", strtotime('+'.$date_end.'days')),
		];
		$this->db->query('INSERT INTO actions VALUES (:id, :title, :description, :email, :code, :photo,:city, :views, :date, :date_end)', $params);

		return $this->db->lastInsertId();
	}

	public function checkCodeExists($code){
		$params = [
			'code' => $code,
		];
		return $this->db->column('SELECT id FROM actions WHERE code = :code', $params);
	}

	public function createRoute($post){
		$date = date("Y-m-d H:i");
		$date_end = date("Y-m-d H:i", strtotime('+'.$_POST['date_end'].'minutes'));
		$client_email = $_SESSION['user']['email'];
		$executor_email = NULL;
		$status = 'search';
		$view = 0;

		$params = [
			'id' => '0',
			'description' => $post['description'],
			'route_from' => $post['route_from'],
			'route_to' => $post['route_to'],
			'cost' => $post['cost'],
			'date' => $date,
			'date_accept' => NULL,
			'date_end' => $date_end,
			'client_email' => $client_email,
			'executor_email' => $executor_email,
			'status' => $status,
			'view' => $view
		];
		$this->db->query('INSERT INTO routes VALUES (:id, :description, :route_from, :route_to, :cost, :date,:date_accept, :date_end, :client_email, :executor_email, :status, :view)', $params);
		return $this->db->lastInsertId();
	}

	public function routesList($route) {

		$client_email = $_SESSION['user']['email'];
		$max = 3;
		$params = [
			'client_email' => $client_email,
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM routes WHERE client_email = :client_email ORDER BY date DESC LIMIT :start, :max', $params);
	}

	public function routesCount(){
		$client_email = $_SESSION['user']['email'];
		$params = [
			'client_email' => $client_email,
		];
		return $this->db->column('SELECT COUNT(id) FROM routes WHERE client_email = :client_email', $params);
	}

	public function routeCancel($id){
		$params = [
			'id' => $id,
		];
		$this->db->query('DELETE FROM routes WHERE id = :id', $params);
	}

	public function checkRouteUser($id){
		$unknownUser = $_SESSION['user']['email'];
		$params = [
			'id' => $id
		];
		$verifyUser = $this->db->column('SELECT client_email FROM routes WHERE id = :id', $params);
		
		if ($unknownUser == $verifyUser) {
			return true;
		}else{
			return false;
		}
	}

}