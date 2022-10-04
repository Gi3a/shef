<?php

namespace application\controllers;

use application\core\Controller;
use application\lib\Pagination;
use application\models\Main;
use application\models\User;
use application\models\Notification;
use application\models\Offer;
use application\models\Message;
use application\models\Request;
use application\models\Balance;
use application\models\Bucket;

class MainController extends Controller {

	public function mainAction() {
		$bucketModel = new Bucket;
		$notificationModel = new Notification;
		$offers = $this->model->syncOffer();
		$actions = $this->model->syncActions();
		$bucketModel->bulkRemovalOffers($offers);
		$bucketModel->bulkRemovalActions($actions);
		$this->model->syncDate();
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'adverts' => $this->model->mainBlock('advert', 'id'),
				'orders' => $this->model->mainBlock('order', 'id'),
				'hots' => $this->model->mainBlock('advert', 'views'),
				'recomended' => $this->model->mainBlock('advert', 'liked'),
				'actions' => $this->model->mainActions(),
				'random_background' => $this->model->randomBackground(),
			];
		}else{
			$vars = [
				'adverts' => $this->model->mainBlock('advert', 'id'),
				'orders' => $this->model->mainBlock('order', 'id'),
				'hots' => $this->model->mainBlock('advert', 'views'),
				'recomended' => $this->model->mainBlock('advert', 'liked'),
				'actions' => $this->model->mainActions(),
				'random_background' => $this->model->randomBackground(),

			];
		}	
		$this->view->render('Shef - крупная онлайн платформа для купле/продажи', $vars);
	}

	public function recomendedAction(){
		$notificationModel = new Notification;
		$this->model->syncDate();
		$pagination = new Pagination($this->route, $this->model->choiceCount($this->route));
		$action = $this->route['action'];
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'pagination' => $pagination->get($action),
				'list' => $this->model->choiceList($this->route, 'liked')
			];
		}else
		$vars = [
			'pagination' => $pagination->get($action),
			'list' => $this->model->choiceList($this->route, 'liked')
		];
		$this->view->render('Рекомендуемое', $vars);
	}

	public function hotAction(){
		$notificationModel = new Notification;
		$this->model->syncDate();
		$pagination = new Pagination($this->route, $this->model->choiceCount($this->route));
		$action = $this->route['action'];
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'pagination' => $pagination->get($action),
				'list' => $this->model->choiceList($this->route, 'views')
			];
		}else
		$vars = [
			'pagination' => $pagination->get($action),
			'list' => $this->model->choiceList($this->route, 'views')
		];
		$this->view->render('Самое горячее', $vars);
	}

	public function aboutAction(){
		$this->view->render('О нас');
	}

	public function advertAction(){
		$userModel = new User;
		$this->model->syncDate();
		$notificationModel = new Notification;
		if (!$this->model->isOfferExists($this->route)) {
			$this->view->errorCode(404);
		}
		$type = $this->model->offerType($this->route);
		if (!empty($_SESSION['user'])) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'comments' => $this->model->commentsData($this->route),
				'commentsCount' => $this->model->commentsCount($this->route['id'])[0],
				'data' => $this->model->offerData($type,$this->route['id'])[0],
				'like' => $this->model->checkLike($this->route['id'])[0],
				'profile' => $this->model->profileData($this->route['id'])[0],
				'meta_desc' => $this->model->metaDesc($this->route['id']),
				'meta_key' => $this->model->metaKey($this->route['id']),
			];
		}else{
			$vars = [
				'comments' => $this->model->commentsData($this->route),
				'commentsCount' => $this->model->commentsCount($this->route['id'])[0],
				'data' => $this->model->offerData($type,$this->route['id'])[0],
				'profile' => $this->model->profileData($this->route['id'])[0],
				'meta_desc' => $this->model->metaDesc($this->route['id']),
				'meta_key' => $this->model->metaKey($this->route['id']),
			];
		}
		$id = $vars['data']['id'];
		$this->model->offerViews($id);
		$this->view->render($vars['data']['title'], $vars);
	}

	public function orderAction(){
		$offerModel = new Offer;
		$type = $this->model->offerType($this->route);
		$notificationModel = new Notification;
		if (!$this->model->isOfferExists($this->route)) {
			$this->view->errorCode(404);
		}
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'comments' => $this->model->commentsData($this->route),
				'commentsCount' => $this->model->commentsCount($this->route['id'])[0],
				'data' => $this->model->offerData($type,$this->route['id'])[0],
				'countExecutors' => $offerModel->countExecutors($this->route['id']),
				'listExecutors' => $offerModel->listExecutors($this->route['id']),
				'suggestionData' => $offerModel->suggestionData($this->route['id'], $_SESSION['user']['email']),
				'orderExecutor' => $offerModel->orderExecutor($this->route['id'], $_SESSION['user']['email']),
				'status' => $offerModel->orderExecutorStatus($this->route['id']),
				'phone' => $this->model->getPhone($this->route['id']),
				'profile' => $this->model->profileData($this->route['id'])[0],
			];
		}else
		$vars = [
			'comments' => $this->model->commentsData($this->route),
			'commentsCount' => $this->model->commentsCount($this->route['id'])[0],
			'data' => $this->model->offerData($type,$this->route['id'])[0],
			'countExecutors' => $offerModel->countExecutors($this->route['id']),
			'listExecutors' => $offerModel->listExecutors($this->route['id']),
			'profile' => $this->model->profileData($this->route['id'])[0],
		];
		$this->view->render($vars['data']['title'], $vars);
	}

	// Advert Manipulation

	public function takeAction(){
		$requestModel = new Request;
		$userModel = new User;
		if (!empty($_POST)) {
			if (!empty($_POST['promocode'])) {
				if (!$requestModel->checkPromocode($_POST['promocode'])) {
				$this->view->message('error', 'Такого промокода не сущесвует');
				}
			}
			if(!$requestModel->validate(['description', 'address'], $_POST)){
				$this->view->message('error', $requestModel->error);
			}
			$offerEmail = $requestModel->offerEmail($this->route['id'])[0];
			$request = $requestModel->checkBasket($_SESSION['user']['email'], $offerEmail['email']);
			if(!$request) {
				$request = $requestModel->requestAdd($_POST, $offerEmail['email'], $_SESSION['user']['email']);
			}
			$requestModel->requestOfferAdd($request,$this->route['id'],$_POST['count'],$_POST['description']);
			$this->view->message('success', 'Подтвердите финальный заказ в заявках!');
		}
	}

	// Order Manipulations

	public function makeAction(){
		$userModel = New User;
		$offerModel = new Offer;
		$notificationModel = new Notification;
		$vars = ['data' => $offerModel->offerData($this->route['id']),];
		if (!$offerModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!empty($_POST)) {
			if(!$userModel->validateOffer(['description', 'cost'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			if(!empty($id = $offerModel->orderStatus($vars['data'][0]['email'], $this->route['id'],$_SESSION['user']['email']))){
				$offerModel->update($id,$_POST);
			}else{
				$offerModel->make($_POST, $vars['data'][0]['email'], $this->route['id'],$_SESSION['user']['email']);
			}

			$email = $vars['data'][0]['email'];
			$offer = $this->route['id'];
			$route = NULL;

			$notificationModel->successNotification($email, $_SESSION['user']['email'].' готов вязть ваш заказ, перейдите в свои объявления', $offer, $route);

			$this->view->message('success', 'Ваше предожение размещено успешно!');
		}
	}

	public function unmakeAction(){
		$userModel = New User;
		$offerModel = new Offer;
		$notificationModel = new Notification;
		$vars = ['data' => $offerModel->offerData($this->route['id']),];
		if (!$offerModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if ($offerModel->mySuggestion($this->route['id'],$_SESSION['user']['email'])) {
			$offerModel->unmake($this->route['id'], $_SESSION['user']['email']);
		}
		$email = $vars['data'][0]['email'];
		$offer = $this->route['id'];
		$route = NULL;
		$notificationModel->errorNotification($email, $_SESSION['user']['email'].' не сможет выполнить ваш заказ', $offer, $route);
		$this->view->redirect('order/'.$this->route['id']);
	}


	public function applyAction(){
		$userModel = New User;
		$offerModel = new Offer;
		$notificationModel = new Notification;
		$vars = ['data' => $offerModel->orderListInfo($this->route['offer']),];
		if (!$offerModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$offerModel->checkOwnOrder($this->route['id'], $_SESSION['user']['email'])) {
			$this->view->errorCode(403);
		}else{
			$offerModel->apply($vars['data']);
			$email = $vars['data'][0]['email_executor'];
			$offer = $this->route['id'];
			$route = NULL;
			$notificationModel->successNotification($email, 'Приступайте к выполнению заказ' . $offer, $offer, $route);
			$offerModel->afterApply($this->route['id']);
			$this->view->redirect('order/'.$this->route['id']);
		}
	}

	public function refuseAction(){
		$notificationModel = new Notification;
		$bucketModel = new Bucket;
		$offerModel = new Offer;
		$vars = ['data' => $offerModel->orderExecutorStatus($this->route['id']),];
		if (!$offerModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$offerModel->checkOwnOrderExecutor($this->route['id'], $_SESSION['user']['email'])) {
			$this->view->errorCode(403);
		}else{
			if (!$offerModel->beforeRefuse($vars['data'])) {
				$this->view->message('error', 'Прошло больше 30 минут, отмена невозможна');
			}
			$offerModel->refuse($vars['data'], $_SESSION['user']['email']);
			$email = $vars['data'][0]['email_executor'];
			$offer = $this->route['id'];
			$route = NULL;
			$notificationModel->errorNotification($email, 'Заказ' . $offer.'отменен', $offer, $route);
			$this->view->redirect('order/'.$this->route['id']);
		}
	}

	public function readyAction(){
		$notificationModel = new Notification;
		$offerModel = new Offer;
		$vars = ['data' => $offerModel->orderExecutorStatus($this->route['id'])];
		if (!$offerModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$offerModel->checkOrderExecutor($this->route['id'], $_SESSION['user']['email'])) {
			$this->view->errorCode(403);
		}
		else{
			$offerModel->ready($vars['data']);
			$email = $vars['data'][0]['email_executor'];
			$offer = $this->route['id'];
			$route = NULL;
			$notificationModel->successNotification($email, 'Ваш <a href="/order/ '.$offer.'> </a> заказ готов!', $offer, $route);
			$this->view->redirect('order/'.$this->route['id']);
		}
	}

	public function cancelAction(){
		$notificationModel = new Notification;
		$offerModel = new Offer;
		$vars = ['data' => $offerModel->orderExecutorStatus($this->route['id'])];
		if (!$offerModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$offerModel->checkOrderExecutor($this->route['id'], $_SESSION['user']['email'])) {
			$this->view->errorCode(403);
		}
		else{
			$offerModel->cancel($vars['data']);
			$email = $vars['data'][0]['email_executor'];
			$offer = $this->route['id'];
			$route = NULL;
			$notificationModel->errorNotification($email, 'Ваш <a href="/order/ '.$offer.'> </a> заказ отменен от выполнения!', $offer, $route);
			$this->view->redirect('order/'.$this->route['id']);
		}
	}

	public function doneAction(){
		$notificationModel = new Notification;
		$offerModel = new Offer;
		$userModel = new User;
		$bucketModel = new Bucket;
		$vars = ['data' => $offerModel->orderExecutorStatus($this->route['id']),];
		if (!$offerModel->isOfferExists($this->route['id'])) {
			$this->view->errorCode(404);
		}
		if (!$offerModel->checkOrderExecutor($this->route['id'], $_SESSION['user']['email'])) {
			$this->view->errorCode(403);
		}
		else{
			$email = $vars['data'][0]['email'];
			$offer = $this->route['id'];
			$route = NULL;
			$notificationModel->errorNotification($email, 'Оплата пришла, заказ ' . $offer . ' будет убран', $offer, $route);

			$userModel->offerDelete($this->route['id']);
			$type = 'offers';
			$bucketModel->deleteImg($this->route['id'], $type);
			$this->view->redirect('orders');
		}
	}

	// Adverts Manipulations

	public function advertsAction(){
		$notificationModel = new Notification;
		$type = $this->model->offerType($this->route);
		$pagination = new Pagination($this->route, $this->model->offersCount($type));
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'pagination' => $pagination->get($this->route['action']),
				'list' => $this->model->offersList($type,$this->route)
			];
		}else{
			$vars = [
				'pagination' => $pagination->get($this->route['action']),
				'list' => $this->model->offersList($type,$this->route)
			];
		}
		$this->view->render('Объявления', $vars);
	}

	public function ordersAction(){
		$notificationModel = new Notification;
		$type = $this->model->offerType($this->route);
		$pagination = new Pagination($this->route, $this->model->offersCount($type));
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'pagination' => $pagination->get($this->route['action']),
				'list' => $this->model->offersList($type,$this->route)
			];
		}else{
			$vars = [
				'pagination' => $pagination->get($this->route['action']),
				'list' => $this->model->offersList($type,$this->route)
			];
		}
		$this->view->render('Заказы', $vars);
	}

	public function advertcategoryAction(){
		$notificationModel = new Notification;
		$type = $this->model->offerType($this->route);
		$pagination = new Pagination($this->route, $this->model->CategoryCount($type,$this->route));
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'pagination' => $pagination->get(),
				'list' => $this->model->categoryList($type,$this->route),
			];
		}else
		$vars = [
			'pagination' => $pagination->get(),
			'list' => $this->model->categoryList($type,$this->route),
		];
		$this->view->render('Категория объявлений', $vars);

	}

	public function ordercategoryAction(){
		$notificationModel = new Notification;
		$type = $this->model->offerType($this->route);
		$pagination = new Pagination($this->route, $this->model->CategoryCount($type,$this->route));
		if (!empty($_SESSION)) {
			$vars = [
				'notifications' => $notificationModel->notificationsCount(),
				'pagination' => $pagination->get(),
				'list' => $this->model->categoryList($type,$this->route),
			];
		}else
		$vars = [
			'pagination' => $pagination->get(),
			'list' => $this->model->categoryList($type,$this->route),
		];
		$this->view->render('Категория заказов', $vars);

	}

	public function searchAction(){
		$notificationModel = new Notification;
		if (!empty($_SESSION)) {
			if (!empty($this->route['search'])) {
				$route = $this->model->routeExplode($this->route['search']);
				$vars = [
					'notifications' => $notificationModel->notificationsCount(),
					'list' => $this->model->searchList($route),
					'params' => $this->model->params($route),
				];
			}
			else{$vars = ['notifications' => $notificationModel->notificationsCount(),];}
		}else{
			if (!empty($this->route['search'])) {
				$route = $this->model->routeExplode($this->route['search']);
				$vars = [
					'list' => $this->model->searchList($route),
					'params' => $this->model->params($route),
				];
			}
			else{$vars = [];}
		}
		$this->view->render('Поиск', $vars);
	}

	public function notificationsAction(){
		$notificationModel = new Notification;
		$pagination = new Pagination($this->route, $notificationModel->notificationsCount());
		$this->model->syncDate();
		$vars = [
			'notifications' => $notificationModel->notificationsCount(),
			'pagination' => $pagination->get(),
			'notification' => $notificationModel->notificationsList($this->route),
		];
		$this->view->render('Уведомления',$vars);
	}

	// Methods

	public function clearAction(){
		$notificationModel = new Notification;
		if (!$this->model->checkUser($this->route['id'])) {
			$this->view->redirect('notifications');
		}
		$notificaition = $notificationModel->delete($this->route);
		$this->view->redirect('notifications');
	}


	public function likeAction(){
		$like = $this->model->checkLike($this->route['id']);
		if ($like == false) {
			$this->model->rateOffer($this->route['id']);
			$count = $this->model->countLikes($this->route['id']);
			$this->model->setLikes($this->route['id'], $count);
		}
		$this->view->redirect('advert/'.$this->route['id']);
	}
	public function dislikeAction(){
		$this->model->unrateOffer($this->route['id']);
		$count = $this->model->countLikes($this->route['id']);
		$this->model->setLikes($this->route['id'], $count);
		$this->view->redirect('advert/'.$this->route['id']);
	}

	public function commentAction(){
		if (!empty($_POST)) {
			if(!$this->model->validate(['description'], $_POST)){
				$this->view->message('error', $this->model->error);
			}
			$this->model->comment($_POST,$this->route['id']);
			$this->view->message('success', 'Ваш комментарий добавлен');
			$this->view->redirect('advert/'.$this->route['id']);
		}
		$this->view->redirect('advert/'.$this->route['id']);
	}

	public function uncommentAction(){
		$this->model->uncomment($this->route);
		$this->view->redirect('advert/'.$this->route['offer']);

	}

	

}