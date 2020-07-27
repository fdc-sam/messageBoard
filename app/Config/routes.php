<?php

// Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
Router::connect('/', array('controller' => 'users', 'action' => 'login', 'home'));
//home
Router::connect('/messenger', array('controller' => 'users', 'action' => 'index', 'messenger'));
//user login
Router::connect('/login', array('controller' => 'users', 'action' => 'login', 'login'));
//user register
Router::connect('/register', array('controller' => 'users', 'action' => 'register', 'register'));

//user messenger
Router::connect('/messenger', array('controller' => 'users', 'action' => 'messenger', 'messenger'));

/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
 	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));




/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
