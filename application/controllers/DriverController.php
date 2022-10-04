<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Driver;
use application\models\User;
use application\models\Main;
use application\models\Notification;


class DriverController extends Controller {

	// Registration Actions
	public function joinAction(){
		$userModel = new User;
		$mainModel = new Main;
		$mainModel->syncDate();
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

	// Driver Action

	public function driverAction(){
		$userModel = new User;
		$mainModel = new Main;
		$mainModel->syncDate();
		if (!$this->model->isDriverExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->driverData($this->route['id'])[0],
		];
		$this->view->render('Драйвер '.$vars['data']['name'], $vars);
	}

	// Routes Actions

	public function routesAction(){
		$pagination = new Pagination($this->route, $this->model->routesCount($this->route));
		$vars = [
			'list' => $this->model->routesList($this->route),
			'pagination' => $pagination->get($this->route),
		];
		$this->view->render('Маршруты',$vars);
	}

	public function routeAction(){
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'search') and ($vars['data']['executor_email'] != $_SESSION['user']['email'])) {
			$this->view->render('Машрут', $vars);
		}else{
			$this->view->errorCode(404);
		}
	}

	public function routeAcceptAction(){
		$notificationModel = new Notification;
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'search') and ($vars['data']['executor_email'] == NULL)) {


			$this->model->routeConfirm($this->route['id']);

			$email = $this->model->clientEmail($this->route['id']);
			$offer = NULL;
			$route = $this->route['id'];
			$notificationModel->statusNotifications($email, 'success', $offer, $route);
			$notificationModel->successNotification($email, 'Ваш заказ взяли, ожидайте доставки', $offer, $route);

			$this->view->redirect('driver/look/'.$this->route['id']);
		}else{
			$this->view->errorCode(404);
		}

	}
	public function routeTakeAction(){
		$notificationModel = new Notification;
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'do') and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			$this->model->routeTake($this->route['id']);
			$email = $this->model->clientEmail($this->route['id']);
			$offer = NULL;
			$route = $this->route['id'];
			$notificationModel->statusNotifications($email, 'success', $offer, $route);
			$notificationModel->defaultNotification($email, 'Водитель прибыл чтобы забрать заказ, выносите его', $offer, $route);
			$this->view->redirect('driver/look/'.$this->route['id']);
		}else{
			$this->view->errorCode(404);
		}
	}
	// Водитель привез заказ
	public function routeGiveAction(){
		$notificationModel = new Notification;
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'take') and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			$this->model->routeGive($this->route['id']);
			$email = $this->model->clientEmail($this->route['id']);
			$offer = NULL;
			$route = $this->route['id'];
			$notificationModel->statusNotifications($email, 'success', $offer, $route);
			$notificationModel->defaultNotification($email, 'Водитель привез заказ, заберите его', $offer, $route);
			$this->view->redirect('driver/look/'.$this->route['id']);
		}else{
			$this->view->errorCode(404);
		}
	}
	public function routeDoneAction(){
		$notificationModel = new Notification;
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'give') and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			$this->model->routeDone($this->route['id']);
			$email = $this->model->clientEmail($this->route['id']);
			$offer = NULL;
			$route = $this->route['id'];
			$notificationModel->statusNotifications($email, 'success', $offer, $route);
			$notificationModel->successNotification($email, 'Ваша доставка выполнена, водитель ожидает оплаты', $offer, $route);
			$this->view->redirect('driver/look/'.$this->route['id']);
		}else{
			$this->view->errorCode(404);
		}

	}
	public function routeCancelAction(){
		$notificationModel = new Notification;
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = ['data' => $this->model->routeData($this->route['id'])[0],];
		if (($vars['data']['status'] == 'do') and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			if (!$this->model->beforeAccept($vars['data'])) {
				$this->view->message('error', 'Прошло больше 15 минут, отмена невозможна');
			}
			$this->model->routeCancel($this->route['id']);
			$email = $this->model->clientEmail($this->route['id']);
			$offer = NULL;
			$route = $this->route['id'];
			$notificationModel->statusNotifications($email, 'success', $offer, $route);
			$notificationModel->successNotification($email, 'Ваш заказ отменен, поиск водителя', $offer, $route);

			$this->view->redirect('driver/routes');
		}else{
			$this->view->errorCode(404);
		}

	}

	public function routePaidAction(){
		$notificationModel = new Notification;
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'done') and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			$this->model->routePaid($this->route['id']);
			$email = $this->model->clientEmail($this->route['id']);
			$offer = NULL;
			$route = $this->route['id'];
			$notificationModel->statusNotifications($email, 'success', $offer, $route);
			$notificationModel->successNotification($email, 'Водитель получил оплату, с вами приятно иметь дело!', $offer, $route);

			$this->view->redirect('driver/routes');
		}else{
			$this->view->errorCode(404);
		}
	}

	public function routeUnpaidAction(){
		$notificationModel = new Notification;
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'done') and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			$email = $this->model->clientEmail($this->route['id']);
			$offer = NULL;
			$route = $this->route['id'];
			$notificationModel->statusNotifications($email, 'success', $offer, $route);
			$notificationModel->errorNotification($email, 'Вы забыли оплатить доставку, водитель ожидает', $offer, $route);

			$this->view->redirect('driver/execute/'.$this->route['id']);
		}else{
			$this->view->errorCode(404);
		}
	}

	// Way Actions
	public function wayAction(){
		$pagination = new Pagination($this->route, $this->model->myRoutesCount($this->route));
		$vars = [
			'list' => $this->model->myRoutesList($this->route),
			'pagination' => $pagination->get($this->route),
		];
		$this->view->render('Мои маршруты',$vars);
	}

	public function executedAction(){
		$pagination = new Pagination($this->route, $this->model->myExecutedCount($this->route));
		$vars = [
			'list' => $this->model->myExecutedList($this->route),
			'pagination' => $pagination->get($this->route),
		];
		$this->view->render('Выполненые маршруты',$vars);
	}

	public function executeAction(){
		if (!$this->model->isExecuteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->executeData($this->route['id'])[0],
		];
		if (($vars['data']['status'] == 'done') and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			$this->view->render('Выполненый', $vars);
		}else{
			$this->view->errorCode(404);
		}
	}

	public function viewAction(){
		if (!$this->model->isRouteExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		$vars = [
			'data' => $this->model->routeData($this->route['id'])[0],
		];
		if ((($vars['data']['status'] == 'do') or ($vars['data']['status'] == 'take') or ($vars['data']['status'] == 'give') ) and ($vars['data']['executor_email'] == $_SESSION['user']['email'])) {
			$this->view->render('Машрут', $vars);
		}else{
			$this->view->errorCode(404);
		}
	}
}