<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Company;
use application\models\User;
use application\models\Main;
use application\models\Notification;

class CompanyController extends Controller {

	// Registration Actions
	public function joinAction(){
		$userModel = new User;
		if (isset($_SESSION['user'])) {
			$this->view->redirect('main');
		}
		if (!empty($_POST)) {

			if(!$userModel->validate(['email','name', 'phone', 'password'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			elseif($userModel->checkEmailExists($_POST['email'])){
				$this->view->message('error', 'E-mail уже зарегестрирован');
			}
			elseif(!$userModel->checkPhoneExists($_POST['phone'])){
				$this->view->message('error', $this->model->error);
			}

			$newUser = $userModel->userAdd($_POST);
			$this->view->message('success', 'Для завершения регистрации подтвердите свой E-mail');
			$this->view->location('login');
		}
		$this->view->render('Регистрация');
	}

	// Company Page Action

	public function companyAction(){
		$mainModel = new Main;
		$userModel = new User;
		$notificationModel = new Notification;
		$mainModel->syncDate();
		$email = $userModel->userEmail($this->route['id']);
		if (!$this->model->isCompanyExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'data' => $this->model->companyData($this->route['id'])[0],
				'list' => $userModel->offersList($email),
			];
		}else 
		$vars = [
			'data' => $this->model->companyData($this->route['id'])[0],
			'list' => $userModel->offersList($email),
		];
		$this->view->render('Компания '.$vars['data']['company'], $vars);
	}

	// My Adverts Action

	public function advertsAction(){
		$userModel = new User;
		$notificationModel = new Notification;
		$pagination = new Pagination($this->route, $userModel->myAdvertsCount());
		$vars = [
			'pagination' => $pagination->get(),
			'list' => $this->model->myAdvertsList($this->route),
			'notifications' => $notificationModel->notificationsCount(),
		];
		$this->view->render('Мои объявления', $vars);
	}
	
}