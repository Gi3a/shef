<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\User;
use application\models\Driver;
use application\models\Main;
use application\models\Bucket;
use application\models\Offer;
use application\models\Notification;
use application\models\Balance;
use application\models\Request;

class UserController extends Controller {

	// Registration Actions
	public function joinAction(){
		$mainModel = new Main;
		$balanceModel = new Balance;
		$mainModel->syncDate();
		
		if (isset($_SESSION['user']) or isset($_SESSION['admin'])) {
			$this->view->redirect('main');
		}
		if (!empty($_POST)) {

			if(!$this->model->validate(['email','name', 'phone', 'password'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			elseif($this->model->checkEmailExists($_POST['email'])){
				$this->view->message('error', 'E-mail уже зарегестрирован');
			}
			elseif($this->model->checkLoginExists($_POST['login'])){
				$this->view->message('error', 'Логин занят');
			}
			elseif($this->model->checkPhoneExists($_POST['phone'])){
				$this->view->message('error', 'Этот телефон уже зарегестрирован');
			}

			$newUser = $this->model->userAdd($_POST);
			$userEmail = $this->model->userEmail($newUser);
			$userPackage = $this->model->userPackage($newUser);
			$balanceModel->getPackage($userPackage,$userEmail);
			$this->view->location('login');
		}
		$this->view->render('Регистрация');
	}

	// User Login Page
	public function userAction(){
		$route = substr($this->route['login'], 1);
		if(!$this->model->checkUserByLogin($route)){
			$this->view->errorCode(404);
		}
		$user = $this->model->getUserByLogin($route)[0];
		if ($user['role'] == 'company') {
			$this->view->redirect('company/'.$user['id']);
		}elseif($user['role'] == 'user'){
			$this->view->redirect('profile/'.$user['id']);
		}elseif($user['role'] == 'driver'){
			$this->view->redirect('driver/'.$user['id']);
		}
	}

	// Recovery Action

	public function recoveryAction(){
		if (isset($_SESSION['user']) or isset($_SESSION['admin'])) {
			$this->view->redirect('main');
		}
		if (!empty($_POST)) {

			if(!$this->model->validate(['email'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			elseif(!$this->model->checkEmailExists($_POST['email'])){
				$this->view->message('error', 'Пользователь не найден');
			}
			elseif(!$this->model->checkLoginExists($_POST['login'])){
				$this->view->message('error', 'Пользователь не найден');
			}
			elseif(!$this->model->checkStatus('email', $_POST['email'])){
				$this->view->message('error', $this->model->error);
			}
			$this->model->recovery($_POST);
			$this->view->message('success', 'Пароля отправлен на E-mail');
			$this->view->location('login');
		}
		$this->view->render('Восстановление пароля');
	}

	// Reset Action

	public function resetAction(){
		if (isset($_SESSION['user']) or isset($_SESSION['admin'])) {
			$this->view->redirect('main');
		}
		if(!$this->model->checkTokenExists($this->route['token'])) {
			$this->view->redirect('login');
		}
		$password = $this->model->reset($this->route['token']);
		$vars = [
			'password' => $password,
		];
		$this->view->render('Пароль отправлен на E-mail', $vars);
	}


	// Confirm Profile Action

	public function confirmAction(){
		$mainModel = new Main;
		$mainModel->syncDate();
		if (isset($_SESSION['user']) or isset($_SESSION['admin'])) {
			$this->view->redirect('main');
		}
		if(!$this->model->checkTokenExists($this->route['token'])) {
			$this->view->redirect('login');
		}
		$this->model->activate($this->route['token']);
		$this->view->render('Регистрация завершена успешно');
	}

	// Login Actions
	public function loginAction(){
		$mainModel = new Main;
		$mainModel->syncDate();
		if (isset($_SESSION['user']) or isset($_SESSION['admin'])) {
			$this->view->redirect('main');
		}
		if (!empty($_POST)) {
			$_POST['email'] = rtrim(htmlspecialchars($_POST['email']));
			if(!$this->model->validate(['password'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			elseif(!$this->model->checkData($_POST['email'],$_POST['password'])){
				$this->view->message('error', 'E-mail, логин, телефон или пароль указан неверно');
			}

			elseif(!$this->model->checkStatus($_POST['email'])){
				$this->view->message('error', $this->model->error);
			}
			$this->model->login($_POST['email']);

			if ($_SESSION['user']['role'] == 'user') {
				$this->view->location('main');
			}
			elseif ($_SESSION['user']['role'] == 'driver') {
				$this->view->location('driver/routes');
			}
			elseif ($_SESSION['user']['role'] == 'company') {
				$this->view->location('company/'.$_SESSION['user']['id']);
			}
		}
		$this->view->render('Вход');
	}

	// Add Advert Action

	public function addAction(){
		$mainModel = new Main;
		$bucketModel = new Bucket;
		$notificationModel = new Notification;
		$balanceModel = new Balance;
		$success = 0;
		if (!empty($_POST)) {
			if(!$this->model->validateOffer(['title', 'description', 'cost', 'city', 'keywords'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			if ($_POST['date_end'] != 'urgent') {
				$countOffers = $balanceModel->countOffers($_SESSION['user']['email']);
				if ($countOffers <= 0 ) {
					$this->view->message('error', 'Вы превысили лимит объявлений');
				}
			}
			$newOffer = $this->model->offerAdd($_POST);
			if (!empty($newOffer)) {
				if (!$bucketModel->imgValidate($_POST, 'add')) {
					$this->view->message('error', $this->model->error);
				}
				$newImg = $bucketModel->saveImg($_FILES['img']['tmp_name'], $newOffer, 'offers');
				if ($_POST['date_end'] != 'urgent') {
					$balanceModel->subtractOffer($_SESSION['user']['email']);
				}
			}
			$this->view->message('success', 'Ваше объявление добавлено успешно!');
			$success = 1;
		}
		$vars = [
			'notifications' => $notificationModel->notificationsCount(),
			'data' => $this->model->getCategory($this->route),
			'limit' => $balanceModel->countOffers($_SESSION['user']['email']),
			'package' => $balanceModel->getPackageUser($_SESSION['user']['email']),
		];
		if ($success >0) {$this->view->location('profile/adverts');}
		$this->view->render('Добавить объявление',$vars);
	}

	// Conduct Action
	public function conductAction(){
		$mainModel = new Main;
		$bucketModel = new Bucket;
		$notificationModel = new Notification;
		$vars = [
			'notifications' => $notificationModel->notificationsCount(),
		];
		if (!empty($_POST)) {
			if(!$this->model->validateOffer(['title', 'description'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			elseif($this->model->checkCodeExists($_POST['code'])){
				$this->view->message('error', 'Этот код занят');
			}
			if (!$bucketModel->imgValidate($_POST, 'add')) {
				$this->view->message('error', $this->model->error);
			}
			$newAction = $this->model->conductAction($_POST);
			$newImg = $bucketModel->saveImg($_FILES['img']['tmp_name'], $newAction, 'actions');
			$this->view->message('success', 'Ваша промо акция добавлена!');
			$this->view->location('main');
		}
		$this->view->render('Провести акцию',$vars);
	}

	// Create Order Action

	public function createAction(){
		$mainModel = new Main;
		$bucketModel = new Bucket;
		$notificationModel = new Notification;
		$vars = [
			'notifications' => $notificationModel->notificationsCount(),
			'data' => $this->model->getCategory($this->route),
		];
		if (!empty($_POST)) {
			if(!$this->model->validateOffer(['title', 'description', 'cost'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			if (!$bucketModel->imgValidate($_POST, 'add')) {
				$this->view->message('error', $this->model->error);
			}
			$newOffer = $this->model->offerAdd($_POST);
			$newImg = $bucketModel->saveImg($_FILES['img']['tmp_name'], $newOffer, 'offers');
			$this->view->message('success', 'Ваш заказ создан успешно!');
			$this->view->location('main');
		}
		$this->view->render('Создать заказ',$vars);
	}

	public function deleteimgAction(){
		$bucketModel = new Bucket;
		$id = $this->route['id'];
		$type = 'offers';

		$bucketModel->deleteImg($id,$type);
		$this->model->imgDeleted($id, $type);
		$this->view->redirect('edit/'.$id);
	}

	public function activateAction(){
		$balanceModel = new Balance;
		if (!$this->model->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$this->model->checkUser($this->route['id'])) {
			$this->view->errorCode(403);
		}
		$countOffers = $balanceModel->countOffers($_SESSION['user']['email']);
		if ($countOffers <= 0 ) {
			$this->view->message('error', 'Вы превысили лимит объявлений');
		}
		$pack = $balanceModel->datePackage();
		$this->model->activateOffer($this->route['id'], $pack);
		$balanceModel->subtractOffer($_SESSION['user']['email']);
		$this->view->redirect('profile/adverts');
	}

	public function deactivateAction(){
		$balanceModel = new Balance;
		$offerModel = new Offer;
		if (!$this->model->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$this->model->checkUser($this->route['id'])) {
			$this->view->errorCode(403);
		}
		$priority = $offerModel->offerPriority($this->route['id']);
		if ($priority != 1.5) {
			$pack = $balanceModel->datePackage();
			$this->model->deactivateOffer($this->route['id'], $pack);
			$balanceModel->appendOffer($_SESSION['user']['email']);
		}
		$this->view->redirect('profile/adverts');
	}

	// Edit Offer Action

	public function editAction(){
		$mainModel = new Main;
		$bucketModel = new Bucket;
		$notificationModel = new Notification;
		if (!$this->model->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$this->model->checkUser($this->route['id'])) {
			$this->view->errorCode(403);
		}
		if (!empty($_FILE['img'])) {
			if (!$bucketModel->imgValidate($_POST, 'add')) {
				$this->view->message('error', $this->model->error);
			}
		}
		$vars = [
			'notifications' => $notificationModel->notificationsCount(),
			'data' => $this->model->offerData($this->route['id'])[0],
			'list' => $this->model->getCategory($this->route),
		];
		if (!empty($_POST)) {
			if (!$this->model->validateOffer(['title', 'description', 'cost'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}
			if ($vars['data']['photo'] == false) {
				if ($_FILES['img']['size'] > 1) {
					$newImg = $bucketModel->saveImg($_FILES['img']['tmp_name'], $this->route['id'], 'offers');
					$this->model->offerEdit($_POST,$this->route['id'], 1);
				}else{
					$this->model->offerEdit($_POST,$this->route['id'], 0);
				}
			}elseif($vars['data']['photo'] == true){
				$this->model->offerEdit($_POST,$this->route['id'], 1);
			}
			$this->view->message('success', 'Сохранено');
		}
		$this->view->render('Редактирование', $vars);
	}

	// Delete Offer Action

	public function deleteAction(){
		$mainModel = new Main;
		$bucketModel = new Bucket;
		$balanceModel = new Balance;
		if (!$this->model->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$this->model->checkUser($this->route['id'])) {
			$this->view->errorCode(403);
		}
		$this->model->offerDelete($this->route['id']);
		$type = 'offers';
		$bucketModel->deleteImg($this->route['id'], $type);
		$balanceModel->appendOffer($_SESSION['user']['email']);
		$this->view->redirect('profile/adverts');
	}

	// Request and Response 
	public function requestsAction(){
		$notificationModel = new Notification;
		$requestModel = new Request;
		$mainModel = new Main;
		$mainModel->syncDate();
		$pagination = new Pagination($this->route, $requestModel->requestCount());
		$vars = [
			'pagination' => $pagination->get(),
			'notifications' => $notificationModel->notificationsCount(),
			'list' => $requestModel->requestList($this->route),
		];
		$this->view->render('Мои заявки',$vars);
	}

	public function requestAction(){
		$notificationModel = new Notification;
		$requestModel = new Request;
		$mainModel = new Main;
		$mainModel->syncDate();
		$offers = $requestModel->requestOffersId($this->route['id']);
		$pagination = new Pagination($this->route, $requestModel->requestOffersCount($offers));
		$vars = [
			'data' => $requestModel->requestView($this->route['id'])[0],
			'offers' => $requestModel->requestOffers($offers, $this->route),
			'pagination' => $pagination->get($this->route),
		];
		$this->view->render('Заявка',$vars);
	}

	public function requestAcceptAction(){
		$notificationModel = new Notification;
		$requestModel = new Request;
		$request = $requestModel->requestOffer($this->route['id'])[0];
		$requestModel->requestAccept($this->route['id']);
		$notificationModel->successNotification($request['offer_customer'], 'Ваш заказ принят, ожидайте готовности', $request['offer_id'], null);
		$this->view->redirect('requests');
	}

	public function requestDeclineAction(){
		$notificationModel = new Notification;
		$requestModel = new Request;
		$request = $requestModel->requestOffer($this->route['id'])[0];
		$requestModel->requestDecline($this->route['id']);
		$notificationModel->errorNotification($request['offer_customer'], 'Просим прощения, ваш заказ не сможет быть выполнен', $request['offer_id'], null);
		$this->view->redirect('requests');
	}

	public function responseAction(){
		$notificationModel = new Notification;
		$requestModel = new Request;
		$mainModel = new Main;
		$mainModel->syncDate();
		$pagination = new Pagination($this->route, $requestModel->responseCount());
		$vars = [
			'pagination' => $pagination->get(),
			'notifications' => $notificationModel->notificationsCount(),
			'list' => $requestModel->responseList($this->route),
		];
		$this->view->render('Мои запросы',$vars);
	}

	// Profile Action

	public function profileAction(){
		$userModel = new User;
		$mainModel = new Main;
		$notificationModel = new Notification;
		$mainModel->syncDate();
		$email = $this->model->userEmail($this->route['id']);
		if (!$this->model->isProfileExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'data' => $this->model->profileData($this->route['id'])[0],
				'list' => $this->model->offersList($email),
			];
		}else 
		$vars = [
			'data' => $this->model->profileData($this->route['id'])[0],
			'list' => $this->model->offersList($email),
		];
		$this->view->render('Пользователь '.$vars['data']['name'], $vars);
	}

	// Settings Profile Action

	public function settingsAction(){
		$bucketModel = new Bucket;
		$notificationModel = new Notification;
		if (!$this->model->isUserExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$this->model->checkSessionUser($this->route['id'])) {
			$this->view->errorCode(403);
		}
		if (!empty($_FILE['img'])) {
			if (!$bucketModel->imgValidate($_POST, 'add')) {
				$this->view->message('error', $this->model->error);
			}
		}
		$vars = [
			'img' => $bucketModel->imgExist($this->route),
			'notifications' => $notificationModel->notificationsCount(),
			'data' => $this->model->profileData($this->route['id'])[0],
		];
		if (!empty($_POST)) {
			if (!$this->model->validate(['email','name', 'phone'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			$id = $this->model->checkEmailExists($_POST['email']);
			if($id and $id != $_SESSION['user']['id']){
				$this->view->message('error', 'Этот E-mail уже используется');
			}
			if (!empty($_POST['password']) and !$this->model->validate(['password'], $_POST)) {
				$this->view->message('error', $this->model->error);
			}
			if ($vars['img'] == false) {
				if ($_FILES['img']['size'] > 1) {
					$newImg = $bucketModel->saveImg($_FILES['img']['tmp_name'], $this->route['id'], 'users');
					$this->model->settings($_POST, 1);
				}else{
					$this->model->settings($_POST, 0);
				}
			}elseif($vars['img'] == true){
				$this->model->settings($_POST, 1);
			}
			$this->view->message('success', 'Сохранено');
		}
		$this->view->render('Настройки аккаунта', $vars);
	}

	public function deleteprofileimgAction(){
		$bucketModel = new Bucket;
		$id = $this->route['id'];
		$type = 'users';

		$bucketModel->deleteImg($id,$type);
		$this->model->imgDeleted($id,$type);
		$this->view->redirect('settings/'.$id);
	}

	// Create Route for Drivers

	public function routeAction(){
		$mainModel = new Main;
		$notificationModel = new Notification;
		$email = $_SESSION['user']['email'];
		$mainModel->syncDate();
		if (!empty($_POST)) {
			if(!$this->model->validateOffer(['description', 'cost'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			$class_id = $this->model->createRoute($_POST);
			$class = 'route';
			$notificationModel->successNotification($email, 'Ожидайте подтверждение водителя', $class, $class_id);
			$this->view->message('success', 'Ваш путь добавлен');
		}
		$vars = [
			'notifications' => $notificationModel->notificationsCount(),
		];
		$this->view->render('Нужно доставить',$vars);
	}


	// View Profile Routes
	public function routesAction(){
		$notificationModel = new Notification;
		$mainModel = new Main;
		$mainModel->syncDate();
		$pagination = new Pagination($this->route, $this->model->routesCount());
		$vars = [
			'pagination' => $pagination->get(),
			'notifications' => $notificationModel->notificationsCount(),
			'list' => $this->model->RoutesList($this->route),
		];
		$this->view->render('Моя доставка',$vars);
	}

	// Cancel Route

	public function cancelAction(){
		$driverModel = new Driver;
		if (!$driverModel->isRouteExists($this->route['id'])) {
			$this->view->redirect('profile/routes');
		}
		if (!$this->model->checkRouteUser($this->route['id'])) {
			$this->view->redirect('profile/routes');
		}
		$vars = ['data' => $driverModel->routeData($this->route['id'])[0],];
		if (!$driverModel->beforeAccept($vars['data'])) {
				$this->view->message('error', 'Прошло больше 15 минут, отмена невозможна');
		}
		$this->model->routeCancel($this->route['id']);
		$this->view->redirect('profile/routes');
	}

	// My Adverts Action

	public function advertsAction(){
		$notificationModel = new Notification;
		$pagination = new Pagination($this->route, $this->model->myAdvertsCount());
		$vars = [
			'pagination' => $pagination->get($this->route),
			'list' => $this->model->myAdvertsList($this->route),
			'notifications' => $notificationModel->notificationsCount(),
		];
		$this->view->render('Мои объявления', $vars);
	}


	// My Orders Action

	public function ordersAction(){
		$notificationModel = new Notification;
		$pagination = new Pagination($this->route, $this->model->myOrdersCount());
		$vars = [
			'pagination' => $pagination->get($this->route),
			'list' => $this->model->myOrdersList($this->route),
			'notifications' => $notificationModel->notificationsCount(),
		];
		$this->view->render('Мои заказы', $vars);	
	}

	// My Liked Action

	public function likedAction(){
		$notificationModel = new Notification;
		$offers = $this->model->likedId($this->route);
		$pagination = new Pagination($this->route, $this->model->myLikedListCount($offers));
		$vars = [
			'pagination' => $pagination->get($this->route),
			'notifications' => $notificationModel->notificationsCount(),
			'list' => $this->model->myLikedList($offers,$this->route),
		];
		$this->view->render('Понравившиеся', $vars);	
	}

	// Exit Action


	public function exitAction(){
		$mainModel = new Main;
		$mainModel->syncDate();
		unset($_SESSION['user']);
		$this->view->redirect('login');

	}
	
	
}