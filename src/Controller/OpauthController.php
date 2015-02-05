<?php

namespace Wouter0100\Opauth\Controller;

use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\DispatcherFactory;
use Cake\Routing\Router;
use Opauth\Opauth\Opauth;
use Opauth\Opauth\OpauthException;

/**
 * CakePHP plugin for Opauth
 *
 * @copyright    Copyright © 2012-2013 U-Zyn Chua (http://uzyn.com), 2015 Wouter van Os (http://wouter0100.nl)
 * @link         http://opauth.org
 * @license      MIT License
 */
class OpauthController extends AppController {

	/**
	 * Opauth instance
	 */
	public $Opauth;

	/**
	 * Catch all for Opauth
	 * Handling callback
	 */
	public function index(){
		$this->_loadOpauth();
		try {
			$callback = [
				'validated' => true,
				'response' => $this->Opauth->run()
			];
		} catch (OpauthException $e) {
			$callback = [
				'validated' => false,
				'message' => $e->getMessage(),
				'code' => $e->getCode()
			];
		}

		$Request = new Request(Configure::read('Opauth.CompleteURL'));
		$Request->data = $callback;

		$dispatcher = DispatcherFactory::create();
		$dispatcher->dispatch($Request, new Response());
		exit();
	}

	/**
	 * Instantiate Opauth
	 *
	 * @param array $config User configuration
	 * @param boolean $run Whether Opauth should auto run after initialization.
	 */
	protected function _loadOpauth($config = null) {
		$config = Configure::read('Opauth.Config');

        /* If Configure::read returned null or not an array, create a empty array */
        if (!is_array($config)) {
            $config = [];
        }

        /* Add defaults to $config array */
		$config += [
			'path' => Router::url([ 'controller' => 'Opauth', 'action' => 'index' ]) . DS,
			'callback' => 'callback',
			'Strategy' => Configure::read('Opauth.Strategy')
		];

		$this->Opauth = new Opauth( $config );
	}
}
