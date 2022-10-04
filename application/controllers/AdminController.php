<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Admin;
use application\models\Main;
use application\models\User;
use application\models\Driver;
use application\models\Bucket;
use application\models\Balance;

class AdminController extends Controller {


	public function mainAction() {
		$this->view->render('Панель управления');
	}

	// Login Actions
	public function loginAction(){
		$mainModel = new Main;
		$mainModel->syncDate();
		if (isset($_SESSION['user'])) {
			$this->view->redirect('main');
		}elseif(isset($_SESSION['admin'])){
			$this->view->redirect('admin/main');
		}
		if (!empty($_POST)) {

			if(!$this->model->validate(['email', 'password'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			elseif(!$this->model->checkData($_POST['email'],$_POST['password'])){
				$this->view->message('error', 'E-mail или пароль указан неверно');
			}
			$this->model->login($_POST['email']);

			if ($_SESSION['admin']['role'] == 'moderator') {
				$this->view->location('admin/main');
			}
			elseif ($_SESSION['admin']['role'] == 'editor') {
				$this->view->location('admin/main');
			}
			elseif ($_SESSION['admin']['role'] == 'admin') {
				$this->view->location('admin/main');
			}
		}
		$this->view->render('Вход');
	}
	// ------------------------------------------------------------------------------
	// Member Actions
	public function deleteAction(){
		if (!$this->model->isAdminExsist($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$this->model->memberDelete($this->route['id']);
		$this->view->redirect('admin/main');
	}
	// ------------------------------------------------------------------------------
	// Users Actions

	public function pauseAction(){
		if (!$this->model->isUserExsist($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$this->model->userPause($this->route['id']);
		$this->view->redirect('admin/users');
	}

	public function activateAction(){
		if (!$this->model->isUserExsist($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$this->model->userActivate($this->route['id']);
		$this->view->redirect('admin/users');
	}

	public function cleanAction(){
		if (!$this->model->isUserExsist($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$this->model->userClean($this->route['id']);
		$this->view->redirect('admin/users');
	}
	// ------------------------------------------------------------------------------
	// Moderators Action
	public function moderatorsAction(){
		$pagination = new Pagination($this->route, $this->model->adminsCount($this->route));
		$vars = [
			'list' => $this->model->adminsList($this->route),
			'pagination' => $pagination->get($this->route)
		];
		$this->view->render('Модераторы', $vars);
	}


	// Editors Action
	public function editorsAction(){
		$pagination = new Pagination($this->route, $this->model->adminsCount($this->route));
		$vars = [
			'list' => $this->model->adminsList($this->route),
			'pagination' => $pagination->get($this->route)
		];
		$this->view->render('Редакторы', $vars);
	}

	// Users Action

	public function usersAction(){
		$pagination = new Pagination($this->route, $this->model->usersCount($this->route));
		$vars = [
			'pagination' => $pagination->get($this->route),
			'list' => $this->model->usersList($this->route),
		];
		$this->view->render('Пользователи', $vars);
	}

	public function driversAction(){
		$pagination = new Pagination($this->route, $this->model->usersCount($this->route));
		$vars = [
			'list' => $this->model->usersList($this->route),
			'pagination' => $pagination->get($this->route),
		];
		$this->view->render('Драйверы', $vars);
	}

	public function companysAction(){
		$pagination = new Pagination($this->route, $this->model->usersCount($this->route));
		$vars = [
			'list' => $this->model->usersList($this->route),
			'pagination' => $pagination->get($this->route),
		];
		$this->view->render('Компании', $vars);
	}

	// Contacts Action
	public function contactsAction(){
		$mainModel = new Main;
		$action = $this->route['action'];
		$pagination = new Pagination($this->route, $this->model->contactCount($this->route));
		$vars = [
			'pagination' => $pagination->get($this->route['action']),
			'list' => $this->model->contactList($this->route)
		];
		$this->view->render('Сообщения', $vars);
	}

	public function contactAction(){
		if (!$this->model->isContactExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->contactData($this->route['id'])[0],
		];
		$this->view->render('Контакт', $vars);
	}

	public function uncontactAction(){
		if (!$this->model->isContactExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$this->model->uncontact($this->route['id']);
		$this->view->redirect('admin/contacts');
	}

	public function frostAction(){
		$userModel = new User;
		$balanceModel = new Balance;
		if (!$userModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$email = $this->model->offerEmail($this->route['id']);
		$pack = $balanceModel->dateUserPackage($email);
		$userModel->deactivateOffer($this->route['id'], $pack);
		$this->view->redirect('admin/main');
	}

	public function unfrostAction(){
		$userModel = new User;
		$balanceModel = new Balance;
		if (!$userModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$email = $this->model->offerEmail($this->route['id']);
		$pack = $balanceModel->dateUserPackage($email);
		$userModel->activateOffer($this->route['id'], $pack);
		$this->view->redirect('admin/main');
	}

	// Adverts Action
	public function advertsAction(){
		$mainModel = new Main;
		$action = $this->route['action'];
		$pagination = new Pagination($this->route, $this->model->offersCount($this->route));
		$vars = [
			'pagination' => $pagination->get($this->route['action']),
			'list' => $this->model->offersList($this->route)
		];
		$this->view->render('Объявления', $vars);
	}

	// Orders Action
	public function ordersAction(){
		$mainModel = new Main;
		$action = $this->route['action'];
		$pagination = new Pagination($this->route, $this->model->offersCount($this->route));
		$vars = [
			'pagination' => $pagination->get($this->route['action']),
			'list' => $this->model->offersList($this->route)
		];
		$this->view->render('Заказы', $vars);
	}

	// Routes Action
	public function routesAction(){
		$driverModel = new Driver;
		$pagination = new Pagination($this->route, $this->model->routesCount($this->route));
		$vars = [
			'list' => $this->model->routesList($this->route),
			'pagination' => $pagination->get($this->route),
		];
		$this->view->render('Маршруты',$vars);
	}


	// Delete Offer Action

	public function wipeAction(){
		$mainModel = new Main;
		$userModel = new User;
		$bucketModel = new Bucket;
		$balanceModel = new Balance;
		if (!$userModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$userModel->offerDelete($this->route['id']);
		$type = 'offers';
		$bucketModel->deleteImg($this->route['id'], $type);
		$email = $this->model->offerEmail($this->route['id']);
		$countOffers = $balanceModel->countOffers($email);
		$balanceOffers = $countOffers + 1;
		$balanceModel->balanceOffers($balanceOffers, $email);
		$this->view->redirect('admin/adverts');
	}

	// Exit Action


	public function exitAction(){
		$mainModel = new Main;
		$mainModel->syncDate();
		unset($_SESSION['admin']);
		$this->view->redirect('login');

	}

	
}