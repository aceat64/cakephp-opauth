<?php

use Cake\Core\Configure;

/**
* CakePHP plugin for Opauth
					 *
 * @copyright    Copyright © 2012-2013 U-Zyn Chua (http://uzyn.com), 2015 Wouter van Os (http://wouter0100.nl)
 * @link         http://opauth.org
 * @license      MIT License
*/

if (file_exists(CONFIG . 'opauth.php')) {
	Configure::load('opauth');
} else {
	Configure::write('Opauth', [
		'Config' => [],
		'CompleteURL' => '/auth/complete',
		'Strategy' => []
	]);
}