<?php
	if(empty($_SESSION)){
		require_once 'nav.tpl';
		require_once 'preloader.tpl';
	}
	elseif(isset($_SESSION['user'])){
		if ($_SESSION['user']['role'] == 'user')
		{
			require_once 'nav-auth.tpl';
			require_once 'preloader.tpl';
		}
		elseif ($_SESSION['user']['role'] == 'driver')
		{
			require_once 'nav-driver.tpl';
			require_once 'preloader.tpl';
		}
		elseif ($_SESSION['user']['role'] == 'company')
		{
			require_once 'nav-company.tpl';
			require_once 'preloader.tpl';
		}
	}
	elseif(isset($_SESSION['admin'])){
		if ($_SESSION['admin']['role'] == 'moderator')
		{
			require_once 'nav-moderator.tpl';
			require_once 'preloader.tpl';
		}
		elseif ($_SESSION['admin']['role'] == 'editor')
		{
			require_once 'nav-editor.tpl';
			require_once 'preloader.tpl';
		}
		elseif ($_SESSION['admin']['role'] == 'admin')
		{
			require_once 'nav-admin.tpl';
			require_once 'preloader.tpl';
		}
	}
	
?>