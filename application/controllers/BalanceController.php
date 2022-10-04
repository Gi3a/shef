<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;
use application\models\User;
use application\models\Balance;
use application\models\Notification;

class BalanceController extends Controller {

	public function packagesAction(){
		$notificationModel = new Notification;
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'packages' => $this->packages,
		];
		}else
		$vars = [
			'packages' => $this->packages,
		];
		$this->view->render('Пакеты', $vars);
	}

	public function packageAction(){
		$notificationModel = new Notification;
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'package' => $this->packages[$this->route['id']],
			];
		}
		$vars = [
			'package' => $this->packages[$this->route['id']],
		];
		$this->view->render('Пакеты', $vars);
	}

	public function buyAction(){
		$notificationModel = new Notification;
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'packages' => $this->packages,
		];
		}else
		$vars = [
			'packages' => $this->packages,
		];
		$this->view->render('Покупка пакета', $vars);

	}

	public function balanceAction(){
		$notificationModel = new Notification;
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				
		];
		}else
		$vars = [
			
		];
		$this->view->render('Баланс', $vars);
	}

	public function historyAction(){
		$notificationModel = new Notification;
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				
		];
		}else
		$vars = [
			
		];
		$this->view->render('История', $vars);
	}

	

}