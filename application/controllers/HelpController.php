<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Help;
use application\models\Notification;
use application\models\User;
use application\models\Main;

class HelpController extends Controller {


	public function helpAction() {
		$this->view->render('Помощь');
	}

	public function agreementsAction(){
		$this->view->render('Правовая информация и политика конфиденциальности');
	}

	public function termsAction(){
		$this->view->render('Пользовательское соглашение');
	}

	public function cookiesAction(){
		$this->view->render('Политика использования cookies');
	}

	public function confidentialityAction(){
		$this->view->render('Политика конфиденциальности');
	}

	public function contactAction(){
		$mainModel = new Main;
		$userModel = new User;
		$mainModel->syncDate();
		if (!empty($_POST)) {
		
			if(!$this->model->validate(['email','title', 'description'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			$this->model->messageAdd($_POST);
			$this->view->message('success', 'Ваше сообщение отправлено');
			$this->view->redirect('main');
		}
		$this->view->render('Отправить сообщение');
	}
}