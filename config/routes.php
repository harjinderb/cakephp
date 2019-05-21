<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);
Router::extensions(['pdf']);
Router::scope('/', function (RouteBuilder $routes) {

	/*Other route definitions as already existing*/

	/**
	 * Here, we are connecting '/' (base path) to a controller called 'Pages',
	 * its action called 'display', and we pass a param to select the view file
	 * to use (in this case, src/Template/Pages/home.ctp)...
	 */
	//  $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

	/**
	 * ...and connect the rest of 'Pages' controller's URLs.
	 */
	//  $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

	// or the admin route element.
	$routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
	$routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword', 'plugin' => false, 'prefix' => false]);

	$routes->connect('/reset-password', ['controller' => 'Users', 'action' => 'resetPassword', 'plugin' => false, 'prefix' => false]);
	$routes->connect('/admin', ['controller' => 'Users', 'action' => 'login']);
	$routes->connect('/parent', ['controller' => 'Users', 'action' => 'login']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'registration']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'bsoProfile']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'index']);

	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);

	/**
	 * Connect catchall routes for all controllers.
	 *
	 * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
	 *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
	 *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
	 *
	 * Any route class can be used with this method, such as:
	 * - DashedRoute
	 * - InflectedRoute
	 * - Route
	 * - Or your own route class
	 *
	 * You can remove these routes once you've connected the
	 * routes you want in your application.
	 */

	$routes->fallbacks(DashedRoute::class);
});

/* Super Admin Routtes */

Router::prefix('admin', function ($routes) {
	$routes->connect('/', ['controller' => 'Users', 'action' => 'login', 'plugin' => false, 'prefix' => false]);
	$routes->connect('/reset-password', ['controller' => 'Users', 'action' => 'resetPassword', 'plugin' => false, 'prefix' => false]);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'registration']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'bsoProfile']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'index']);
	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});

/* Parent Module Routtes */

Router::prefix('parent', function ($routes) {
	// $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'registration']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'bsoProfile']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'index']);
	$routes->connect('/reset-password', ['controller' => 'Users', 'action' => 'resetPassword', 'plugin' => false, 'prefix' => false]);
	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute', 'prefix' => 'parent']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});

/* Parent Module Routtes */

Router::prefix('employee', function ($routes) {
	$routes->connect('/employees', ['controller' => 'Employees', 'action' => 'dashboard', 'prefix' => 'employee']);
	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute', 'prefix' => 'employee']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'registration']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'bsoProfile']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'index']);
	// $routes->connect('/reset-password', ['controller' => 'Users', 'action' => 'resetPassword','plugin'=>false,'prefix'=>false]);
	// $routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute','prefix'=>'parent']);
	// $routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});

/* APIs Routtes */

Router::prefix('api', function ($routes) {
	$routes->setExtensions(['json', 'xml']);
	//$routes->connect('/', ['controller' => 'Users', 'action' => 'index']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'registration']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'bsoProfile']);
	// $routes->connect('/:controller/:action/', ['controller' => 'Users', 'action' => 'index']);
	$routes->connect('/:login', ['controller' => 'Users', 'action' => 'login']);
	$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);
	$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);
});

// Using the static method.
// Router::connect('/', ['controller' => 'Articles', 'action' => 'index']);

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
