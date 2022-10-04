<?php

namespace application\core;

use application\core\View;

abstract class Controller {

	public $route;
	public $view;
	public $acl;
	public $cloud;
	public $loadbucket;

	public function __construct($route) {
		$this->route = $route;
		if (!$this->checkAcl()) {
			View::errorCode(403);
		}
		$this->view = new View($route);
		$this->model = $this->loadModel($route['controller']);
		$this->packages = require 'application/config/packages.php';
		$this->cloud = require 'application/config/cloud.php';
		$this->loadbucket = require 'application/config/autoload.php';
	}

	public function loadModel($name) {
		$path = 'application\models\\'.ucfirst($name);
		if (class_exists($path)) {
			return new $path;
		}
	}

	public function checkAcl() {
		$this->acl = require 'application/acl/'.$this->route['controller'].'.php';
		if ($this->isAcl('all')) {
			return true;
		}
		elseif(isset($_SESSION['user']) ){
			if ($_SESSION['user']['role'] == 'user' and $this->isAcl('user'))
			{
				return true;
			}
			elseif ($_SESSION['user']['role'] == 'driver' and $this->isAcl('driver'))
			{
				return true;
			}
			elseif ($_SESSION['user']['role'] == 'company' and $this->isAcl('company'))
			{
				return true;
			}
		}
		elseif(isset($_SESSION['admin'])){
			if ($_SESSION['admin']['role'] == 'moderator'and $this->isAcl('moderator'))
			{
				return true;
			}
			elseif ($_SESSION['admin']['role'] == 'editor' and $this->isAcl('editor'))
			{
				return true;
			}
			elseif ($_SESSION['admin']['role'] == 'admin' and $this->isAcl('admin'))
			{
				return true;
			}
		}
		return false;
	}

	public function isAcl($key) {
		return in_array($this->route['action'], $this->acl[$key]);
	}

}