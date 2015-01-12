<?php

use Cake\Routing\Router;

/**
 * CakePHP plugin for Opauth
 *
 * @copyright    Copyright © 2012-2013 U-Zyn Chua (http://uzyn.com), 2015 Wouter van Os (http://wouter0100.nl)
 * @link         http://opauth.org
 * @license      MIT License
 */

/**
 * Routing for Opauth
 */
Router::plugin('Wouter0100/Opauth', [ 'path' => '/auth' ], function ($routes) {
	$routes->connect('/*', [ 'controller' => 'Opauth', 'action' => 'index' ]);
});
