<?php

namespace application\models;

use application\core\Model;


class Main extends Model {

	public $error;

	public function validate($input, $post){
		$rules = [
			'description' => [
				'pattern' => '#^[а-яА-ЯёЁa-zA-z0-9_.,! -]{2,512}$#u',
				'message' => 'Комментарий некорректен (от 2 до 512 символов)',
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

	public function syncOffer(){
		$offers = ['type' => 'advert','date_end' => date('Y-m-d H:i'),];
		return $this->db->row('SELECT id FROM offers WHERE date_end <= :date_end AND type = :type AND priority > 1', $offers);
	}

	public function syncActions(){
		$actions = ['date_end' => date('Y-m-d H:i'),];
		return $this->db->row('SELECT id FROM actions WHERE date_end <= :date_end', $actions);
	}


	public function syncDate(){
		$offers = ['type' => 'advert','date_end' => date('Y-m-d H:i'),];
		$routes = ['status' => 'search','date_end' => date('Y-m-d H:i'),];
		$packages = ['date_end' => date('Y-m-d H:i'),];

		$this->db->query('DELETE FROM offers WHERE date_end <= :date_end AND type = :type AND priority = 1.5', $offers);
		$this->db->query('UPDATE offers SET status = 0 WHERE date_end <= :date_end AND type = :type AND ((priority = 1) OR (priority = 2))', $offers);
		$this->db->query('DELETE FROM routes WHERE date_end <= :date_end AND status = :status', $routes);
		$this->db->query('DELETE FROM actions WHERE date_end <= :date_end', $packages);
		$this->db->query('UPDATE packages SET offers = 7, date = :date_end, date_end = NULL WHERE ((date_end <= :date_end) AND (date_end != NULL) )', $packages);

	}


	public function checkLike($id){
		$user = $_SESSION['user']['id'];
		$params = [
			'offer' => $id,
			'user' => $user
		];

		$query = $this->db->column('SELECT id FROM likes WHERE offer = :offer AND user = :user', $params);
		return $query;

	}

	public function rateOffer($id){
		$user = $_SESSION['user']['id'];
		$params = [
			'id' => '0',
			'offer' => $id,
			'user' => $user,
		];

		$like = $this->db->query('INSERT INTO likes VALUES (:id, :offer, :user)', $params);
	}

	public function unrateOffer($id){
		$user = $_SESSION['user']['id'];
		$params = [
			'offer' => $id,
			'user' => $user,
		];

		$like = $this->db->query('DELETE FROM likes WHERE offer = :offer AND user = :user', $params);
	}

	public function countLikes($id){
		$params = [
			'offer' => $id,
		];
		return $this->db->column('SELECT COUNT(id) FROM likes WHERE offer = :offer', $params);
	}

	public function setLikes($id, $count){
		$params = [
			'id' => $id,
			'liked' => $count
		];
		$this->db->query('UPDATE offers SET liked = :liked WHERE id = :id', $params);
	}

	public function comment($post,$id){
		$date = date("Y-m-d H:i");
		$email = $_SESSION['user']['email'];
		$params = [
			'id' => '0',
			'email' => $email,
			'offer' => $id,
			'description' => $post['description'],
			'date' => $date,
		];
		$this->db->query('INSERT INTO comments VALUES (:id, :email, :offer, :description, :date)', $params);

	}

	public function uncomment($route){
		$id = $route['id'];
		$offer= $route['offer'];
		$params = [
			'id' => $id,
			'offer' => $offer,
		];
		$this->db->query('DELETE FROM comments WHERE offer = :offer AND id = :id', $params);

	}

	public function offerViews($id){
		$params = [
			'id' => $id
		];
		$this->db->query('UPDATE offers SET views = views + 1 WHERE id = :id', $params);
	}

	public function commentsData($route){
		$params = [
			'offer' => $route['id'],
		];
		return $this->db->row('SELECT * FROM comments WHERE offer = :offer ORDER BY id', $params);
	}

	public function commentsCount($id) {
		$params = [
			'offer' => $id,
		];
		$counts[] = $this->db->column('SELECT COUNT(id) FROM comments WHERE offer = :offer', $params);
		return $counts;
	}

	public function checkUser($id){
		$params = ['id' => $id,];
		$unknownUser = $_SESSION['user']['email'];
		$verifyUser = $this->db->column('SELECT email FROM notifications WHERE id = :id', $params);
		
		if ($unknownUser == $verifyUser) {
			return true;
		}else{
			return false;
		}
		
	}

	public function getPhone($id){
		$params = ['id' => $id,];
		$email = $this->db->column('SELECT email FROM offers WHERE id = :id', $params);
		$vars = ['email' => $email];
		$phone = $this->db->column('SELECT phone FROM users WHERE email = :email', $vars);
		return $phone;
	}

	// Exists Offer or Category -------------------------------------------------------------------------------------------------------

	public function isOfferExists($route){
		if (substr($route['action'], 0, 6) == 'advert') {$type = 'advert';}
		elseif(substr($route['action'], 0, 5) == 'order'){$type = 'order';}
		$params = [
			'id' => $route['id'],
			'type' => $type
		];
		return $this->db->column('SELECT id FROM offers WHERE id = :id AND type = :type', $params);
	}

	public function isCategoryExists($id){
		$params = [
			'id' => $id,
		];
		return $this->db->column('SELECT id FROM categories WHERE id = :id', $params);
	}


	// Offers Lists and Counts -------------------------------------------------------------------------------------------------------

	public function offerType($route){
		if (substr($route['action'], 0, 6) == 'advert') {$type = 'advert';}
		elseif(substr($route['action'], 0, 5) == 'order'){$type = 'order';}
		return $type;
	}

	

	public function offerData($type,$id){
		$params = ['id' => $id,'type' => $type];
		return $this->db->row('SELECT * FROM offers WHERE id = :id AND type = :type', $params);
	}

	public function offersCount($type) {
		$params = ['type' => $type];
		return $this->db->column('SELECT COUNT(id) FROM offers WHERE (type = :type) AND (status != 0)', $params);
	}

	public function offersList($type,$route) {
		$max = 3;
		$params = [
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
			'type' => $type
		];
		if (!empty($route['sort'])) {$sort = substr($route['sort'], 6);} else {$sort = 'id';}
		return $this->db->row('SELECT * FROM offers WHERE (type = :type) AND (status != 0) ORDER BY '.$sort.' DESC, priority DESC LIMIT :start, :max', $params);
		
	}

	
	// Categories Methods -------------------------------------------------------------------------------------------------------


	public function offersCategoryCount($category){
		$params = [
			'category' => $category,
		];
		return $this->db->column('SELECT COUNT(id) FROM offers WHERE category = :category AND status != 0', $params);
	}

	public function allCategoriesList($route) {
		$max = 3;
		$params = [
			'category' => $route,
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		return $this->db->row('SELECT * FROM offers WHERE category = :category AND status != 0 ORDER BY priority DESC LIMIT :start, :max', $params);
	}

	public function categoryCount($type,$route){
		$params = [
			'category' => $route['category'],
			'type' => $type,
		];
		return $this->db->column('SELECT COUNT(id) FROM offers WHERE type = :type AND category = :category AND status != 0', $params);
	}

	public function categoryList($type,$route){
		$max = 3;
		$params = [
			'category' => $route['category'],
			'type' => $type,
			'max' => $max,
			'start' => ((($route['page'] ?? 1) - 1) * $max),
		];
		if (!empty($route['sort'])) {
			$sort = substr($route['sort'], 6);
			return $this->db->row('SELECT * FROM offers WHERE category = :category AND type = :type AND status != 0 ORDER BY '.$sort.' DESC, priority DESC LIMIT :start, :max', $params);
		}
		return $this->db->row('SELECT * FROM offers WHERE category = :category AND type = :type AND status != 0 ORDER BY priority DESC LIMIT :start, :max', $params);
	}

	// Main Page list -------------------------------------------------------------------------------------------------------

	public function mainBlock($type,$by) {
		$params = ['type' => $type];
		return $this->db->row('SELECT * FROM offers WHERE type = :type AND status != 0 ORDER BY '.$by.' DESC, priority DESC LIMIT 7', $params);
	}

	public function mainActions(){
		return $this->db->row('SELECT * FROM actions');
	}

	public function randomBackground(){
		$params = ['type' => 'advert'];
		return $this->db->column('SELECT id FROM offers WHERE type = :type ORDER BY views DESC, priority DESC LIMIT 1', $params);
	}

	public function choiceList($route,$type){
		$max = 3;
		$params = ['max' => $max,'start' => ((($route['page'] ?? 1) - 1) * $max),];
		return $this->db->row('SELECT * FROM offers WHERE status != 0 ORDER BY '.$type.' DESC, priority DESC LIMIT :start, :max',$params);
	}

	public function choiceCount($route){
		return $this->db->column('SELECT count(id) FROM offers WHERE status != 0');
	}


	// Search Methods -------------------------------------------------------------------------------------------------------

	public function searchCount($route){
		$params = [
			'type' => $type,
			'cost_from' => $cost_from,
			'cost_to' => $cost_to,
		];
		if ($value != 'list') {
			$vquery = "((title LIKE '%$value%') OR (description LIKE '%$value%')) AND";
		}else{$vquery = '';}

		if ($category != 'all') {
			$cquery = "(category = '$category') AND";
		}else{$cquery = '';}

		if ($city != 'all') {
			$gquery = "(city = '$city') AND";
		}else{$gquery = "";}

		return $this->db->column("SELECT count(id) FROM offers WHERE ".$vquery." ".$cquery." ".$gquery." (type = :type) AND ((cost >= :cost_from) AND (cost <= :cost_to))", $params);
	}

	public function routeExplode($route){
		$route = substr($route, 14);
		$route = urldecode($route);
		return $route;
	}

	public function searchList($route){
		list($value, $type, $category, $sort, $cost_from, $cost_to, $city) = explode(",", $route);
		$params = [
			'sort' => $sort,
			'type' => $type,
			'cost_from' => $cost_from,
			'cost_to' => $cost_to,
		];
		if ($value != 'list') {
			$vquery = "((title LIKE '%$value%') OR (description LIKE '%$value%') OR(keywords LIKE '%$value%') ) AND";
		}else{$vquery = '';}

		if ($category != 'all') {
			$cquery = "(category = '$category') AND";
		}else{$cquery = '';}

		if ($city != 'all') {
			$gquery = "(city LIKE '%$city%') AND";
		}else{$gquery = "";}

		return $this->db->row("SELECT * FROM offers WHERE ".$vquery." ".$cquery." ".$gquery." (type = :type) AND ((cost >= :cost_from) AND (cost <= :cost_to)) AND (status != 0) ORDER BY :sort DESC, priority DESC", $params);
	}

	public function params($route){
		list($value, $type, $category, $sort, $cost_from, $cost_to, $city) = explode(",", $route);
		$params = [
			'value' => $value,
			'type' => $type,
			'category' => $category,
			'sort' => $sort,
			'cost_from' => $cost_from,
			'cost_to' => $cost_to,
			'city' => $city,
		];
		return $params;
	}

	public function profileData($id){
		$params = ['id'=> $id];
		$email = $this->db->column("SELECT email FROM offers WHERE id = :id", $params);
		$email = ['email' => $email];
		return $this->db->row("SELECT * FROM users WHERE email = :email", $email);
	}

	/* Meta Description and Keywords */

	public function metaDesc($id){
		$params = ['id'=>$id];
		return $this->db->row('SELECT title,category,description,city FROM offers WHERE id = :id AND status = 1', $params);
	}

	public function metaKey($id){
		$params = ['id'=>$id];
		return $this->db->row('SELECT title,keywords,city FROM offers WHERE id = :id AND status = 1', $params);
	}
	
	
}