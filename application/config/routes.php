<?php

return [
/* ------------------------------------ */
	// Main Controller
	'' => [
		'controller' => 'main',
		'action' => 'main',
	],
	'{login:@[a-zA-Z0-9._]+$}' => [
		'controller' => 'user',
		'action' => 'user',
	],
	'main' => [
		'controller' => 'main',
		'action' => 'main',
	],
	'main/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'main',
	],
	'test' => [
		'controller' => 'main',
		'action' => 'test',
	],
	'about' => [
		'controller' => 'main',
		'action' => 'about',
	],
	'recomended' => [
		'controller' => 'main',
		'action' => 'recomended',
	],
	'recomended/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'recomended',
	],
	'hot' => [
		'controller' => 'main',
		'action' => 'hot',
	],
	'hot/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'hot',
	],
	'advert/{id:\d+}' => [
		'controller' => 'main',
		'action' => 'advert',
	],
	'advert/{id:\d+}/like' => [
		'controller' => 'main',
		'action' => 'like',
	],
	'advert/{id:\d+}/dislike' => [
		'controller' => 'main',
		'action' => 'dislike',
	],
	'{id:\d+}/comment' => [
		'controller' => 'main',
		'action' => 'comment',
	],
	'{offer:\d+}/uncomment/{id:\d+}' => [
		'controller' => 'main',
		'action' => 'uncomment',
	],
	'order/{id:\d+}' => [
		'controller' => 'main',
		'action' => 'order',
	],
	'adverts' => [
		'controller' => 'main',
		'action' => 'adverts',
	],
	'adverts/{sort:\?\w+\=+\w+}' => [
		'controller' => 'main',
		'action' => 'adverts',
	],
	'adverts/{sort:\?\w+\=+\w+}/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'adverts',
	],
	'adverts/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'adverts',
	],
	'orders' => [
		'controller' => 'main',
		'action' => 'orders',
	],
	'orders/{sort:\?\w+\=+\w+}' => [
		'controller' => 'main',
		'action' => 'orders',
	],
	'orders/{sort:\?\w+\=+\w+}/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'orders',
	],
	'orders/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'orders',
	],
	'all/{category:\w+}' => [
		'controller' => 'main',
		'action' => 'allcategory',
	],
	'all/{category:\w+}/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'allcategory',
	],
	'adverts/{category:\w+}' => [
		'controller' => 'main',
		'action' => 'advertcategory',
	],
	'offer/{id:\d+}/take' => [
		'controller' => 'main',
		'action' => 'take',
	],
	'adverts/{category:\w+}/{sort:\?\w+\=+\w+}' => [
		'controller' => 'main',
		'action' => 'advertcategory',
	],
	'adverts/{category:\w+}/{sort:\?\w+\=+\w+}/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'advertcategory',
	],
	'adverts/{category:\w+}/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'advertcategory',
	],
	'orders/{category:\w+}/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'ordercategory',
	],
	'orders/{category:\w+}' => [
		'controller' => 'main',
		'action' => 'ordercategory',
	],
	'orders/{category:\w+}/{sort:\?\w+\=+\w+}' => [
		'controller' => 'main',
		'action' => 'ordercategory',
	],
	'orders/{category:\w+}/{sort:\?\w+\=+\w+}/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'ordercategory',
	],
	'order/{id:\d+}/make' => [
		'controller' => 'main',
		'action' => 'make',
	],
	'order/{id:\d+}/unmake' => [
		'controller' => 'main',
		'action' => 'unmake',
	],
	'order/{id:\d+}/{offer:\d+}/apply' => [
		'controller' => 'main',
		'action' => 'apply',
	],
	'order/{id:\d+}/refuse' => [
		'controller' => 'main',
		'action' => 'refuse',
	],
	'order/{id:\d+}/{offer:\d+}/ready' => [
		'controller' => 'main',
		'action' => 'ready',
	],
	'order/{id:\d+}/{offer:\d+}/cancel' => [
		'controller' => 'main',
		'action' => 'cancel',
	],
	'order/{id:\d+}/done' => [
		'controller' => 'main',
		'action' => 'done',
	],

	// Help Route --------------------------------------------------------------------------------------------------------
	'help' => [
		'controller' => 'help',
		'action' => 'help',
	],

	'agreements' => [
		'controller' => 'help',
		'action' => 'agreements',
	],

	'agreements/terms' => [
		'controller' => 'help',
		'action' => 'terms',
	],
	'agreements/cookies' => [
		'controller' => 'help',
		'action' => 'cookies',
	],
	'agreements/confidentiality' => [
		'controller' => 'help',
		'action' => 'confidentiality',
	],

	'contact' => [
		'controller' => 'help',
		'action' => 'contact',
	],

	// Search Route --------------------------------------------------------------------------------------------------------
	'search' => [
		'controller' => 'main',
		'action' => 'search',
	],

	// search
	'search/{search:[a-zA-Z0-9=+?.%,-]+$}' => [
		'controller' => 'main',
		'action' => 'search',
	],


	
	// Notifications Route --------------------------------------------------------------------------------------------------------
	'notifications' => [
		'controller' => 'main',
		'action' => 'notifications',
	],
	'notifications/{page:\d+}' => [
		'controller' => 'main',
		'action' => 'notifications',
	],
	'notification/{id:\d+}/clear' => [
		'controller' => 'main',
		'action' => 'clear',
	],
/* ------------------------------------ */
	// Balance Controller
	'packages' => [
		'controller' => 'balance',
		'action' => 'packages',
	],
	'package/{id:\d+}' => [
		'controller' => 'balance',
		'action' => 'package',
	],
	'package/{id:\d+}/buy' => [
		'controller' => 'balance',
		'action' => 'buy',
	],
	'balance/{id:\d+}' => [
		'controller' => 'balance',
		'action' => 'balance',
	],
	'balance/history/{id:\d+}' => [
		'controller' => 'balance',
		'action' => 'history',
	],
	
/* ------------------------------------ */
	// User Controller
	'profile/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'profile',
	],
	'profile/{id:\d+}/{page:\d+}' => [
		'controller' => 'user',
		'action' => 'profile',
	],
	'requests' => [
		'controller' => 'user',
		'action' => 'requests',
	],
	'request/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'request',
	],
	'request/{id:\d+}/accept' => [
		'controller' => 'user',
		'action' => 'requestAccept',
	],
	'request/{id:\d+}/decline' => [
		'controller' => 'user',
		'action' => 'requestDecline',
	],
	'response' => [
		'controller' => 'user',
		'action' => 'response',
	],
	'settings/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'settings',
	],
	'login' => [
		'controller' => 'user',
		'action' => 'login',
	],
	'join' => [
		'controller' => 'user',
		'action' => 'join',
	],
	'join/confirm/{token:\w+}' => [
		'controller' => 'user',
		'action' => 'confirm',
	],
	'join/reset/{token:\w+}' => [
		'controller' => 'user',
		'action' => 'reset',
	],
	'profile/adverts' => [
		'controller' => 'user',
		'action' => 'adverts',
	],
	'profile/adverts/{page:\d+}' => [
		'controller' => 'user',
		'action' => 'adverts',
	],
	'profile/orders' => [
		'controller' => 'user',
		'action' => 'orders',
	],
	'profile/orders/{page:\d+}' => [
		'controller' => 'user',
		'action' => 'orders',
	],
	'recovery' => [
		'controller' => 'user',
		'action' => 'recovery',
	],
	'create/route' => [
		'controller' => 'user',
		'action' => 'route',
	],
	'liked' => [
		'controller' => 'user',
		'action' => 'liked',
	],
	'liked/{page:\d+}' => [
		'controller' => 'user',
		'action' => 'liked',
	],
	'profile/routes' => [
		'controller' => 'user',
		'action' => 'routes',
	],
	'profile/routes/{page:\d+}' => [
		'controller' => 'user',
		'action' => 'routes',
	],
	'profile/route/cancel/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'cancel',
	],
	'add/advert' => [
		'controller' => 'user',
		'action' => 'add',
	],
	'create/order' => [
		'controller' => 'user',
		'action' => 'create',
	],
	'conduct/action' => [
		'controller' => 'user',
		'action' => 'conduct',
	],
	'delete/img/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'deleteimg',
	],
	'delete/profile/img/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'deleteprofileimg',
	],
	'activate/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'activate',
	],
	'deactivate/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'deactivate',
	],
	'edit/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'edit',
	],
	'delete/{id:\d+}' => [
		'controller' => 'user',
		'action' => 'delete',
	],

	'exit' => [
		'controller' => 'user',
		'action' => 'exit',
	],
	
/* ------------------------------------ */
	// Company Controller
	'join/company' => [
		'controller' => 'company',
		'action' => 'join',
	],
	'company/{id:\d+}' => [
		'controller' => 'company',
		'action' => 'company',
	],
	'company/adverts' => [
		'controller' => 'company',
		'action' => 'adverts',
	],


/* ------------------------------------ */
	// Driver Controller
	'join/driver' => [
		'controller' => 'driver',
		'action' => 'join',
	],
	'driver/{id:\d+}' => [
		'controller' => 'driver',
		'action' => 'driver',
	],
	'driver/routes' => [
		'controller' => 'driver',
		'action' => 'routes',
	],
	'driver/routes/{page:\d+}' => [
		'controller' => 'driver',
		'action' => 'routes',
	],
	'driver/route/{id:\d+}' => [
		'controller' => 'driver',
		'action' => 'route',
	],
	'driver/route/{id:\d+}/accept' => [
		'controller' => 'driver',
		'action' => 'routeAccept',
	],
	'driver/route/{id:\d+}/done' => [
		'controller' => 'driver',
		'action' => 'routeDone',
	],
	'driver/route/{id:\d+}/take' => [
		'controller' => 'driver',
		'action' => 'routeTake',
	],
	'driver/route/{id:\d+}/give' => [
		'controller' => 'driver',
		'action' => 'routeGive',
	],
	'driver/route/{id:\d+}/cancel' => [
		'controller' => 'driver',
		'action' => 'routeCancel',
	],
	'driver/route/{id:\d+}/paid' => [
		'controller' => 'driver',
		'action' => 'routePaid',
	],
	'driver/route/{id:\d+}/unpaid' => [
		'controller' => 'driver',
		'action' => 'routeUnpaid',
	],
	'driver/way' => [
		'controller' => 'driver',
		'action' => 'way',
	],
	'driver/way/{page:\d+}' => [
		'controller' => 'driver',
		'action' => 'way',
	],
	'driver/executed' => [
		'controller' => 'driver',
		'action' => 'executed',
	],
	'driver/execute/{id:\d+}' => [
		'controller' => 'driver',
		'action' => 'execute',
	],
	'driver/look/{id:\d+}' => [
		'controller' => 'driver',
		'action' => 'view',
	],
/* ------------------------------------ */
	// Admin Controller
	'admin/login' => [
		'controller' => 'admin',
		'action' => 'login',
	],
	'admin/moderators' => [
		'controller' => 'admin',
		'action' => 'moderators',
	],
	'admin/moderators/{page:\d+}' => [
		'controller' => 'admin',
		'action' => 'moderators',
	],
	'admin/editors' => [
		'controller' => 'admin',
		'action' => 'editors',
	],
	'admin/editors/{page:\d+}' => [
		'controller' => 'admin',
		'action' => 'editors',
	],
	'admin/member/{id:\d+}/delete' => [
		'controller' => 'admin',
		'action' => 'delete',
	],

	'admin/users' => [
		'controller' => 'admin',
		'action' => 'users',
	],
	'admin/users/{page:\d+}' => [
		'controller' => 'admin',
		'action' => 'users',
	],
	'admin/drivers' => [
		'controller' => 'admin',
		'action' => 'drivers',
	],
	'admin/drivers/{page:\d+}' => [
		'controller' => 'admin',
		'action' => 'drivers',
	],
	'admin/companys' => [
		'controller' => 'admin',
		'action' => 'companys',
	],
	'admin/companys/{page:\d+}' => [
		'controller' => 'admin',
		'action' => 'companys',
	],
	'admin/user/{id:\d+}/refresh' => [
		'controller' => 'admin',
		'action' => 'refresh',
	],
	'admin/user/{id:\d+}/activate' => [
		'controller' => 'admin',
		'action' => 'activate',
	],
	'admin/user/{id:\d+}/pause' => [
		'controller' => 'admin',
		'action' => 'pause',
	],
	'admin/user/{id:\d+}/clean' => [
		'controller' => 'admin',
		'action' => 'clean',
	],



	'admin/{id:\d+}/frost' => [
		'controller' => 'admin',
		'action' => 'frost',
	],

	'admin/{id:\d+}/unfrost' => [
		'controller' => 'admin',
		'action' => 'unfrost',
	],



	'admin/adverts' => [
		'controller' => 'admin',
		'action' => 'adverts',
	],
	'admin/adverts/{page:\w+}' => [
		'controller' => 'admin',
		'action' => 'adverts',
	],
	'admin/orders' => [
		'controller' => 'admin',
		'action' => 'orders',
	],
	'admin/orders/{page:\w+}' => [
		'controller' => 'admin',
		'action' => 'orders',
	],
	'admin/routes' => [
		'controller' => 'admin',
		'action' => 'routes',
	],
	'admin/routes/{page:\w+}' => [
		'controller' => 'admin',
		'action' => 'routes',
	],
	'admin/contacts' => [
		'controller' => 'admin',
		'action' => 'contacts',
	],
	'admin/contact/{id:\d+}' => [
		'controller' => 'admin',
		'action' => 'contact',
	],
	'uncontact/{id:\d+}' => [
		'controller' => 'admin',
		'action' => 'uncontact',
	],

	'wipe/{id:\d+}' => [
		'controller' => 'admin',
		'action' => 'wipe',
	],
	'admin/main' => [
		'controller' => 'admin',
		'action' => 'main',
	],
	'admin/exit' => [
		'controller' => 'admin',
		'action' => 'exit',
	],
];