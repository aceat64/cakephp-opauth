<?php

namespace Wouter0100\Opauth\Controller;

use Cake\Core\Configure;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\DispatcherFactory;
use Cake\Routing\Router;
use Opauth\Opauth\Opauth;

/**
 * CakePHP plugin for Opauth
 *
 * @copyright    Copyright © 2012-2013 U-Zyn Chua (http://uzyn.com), 2015 Wouter van Os (http://wouter0100.nl)
 * @link         http://opauth.org
 * @license      MIT License
 */
class OpauthController extends AppController {

	public $uses = array();

	/**
	 * Opauth instance
	 */
	public $Opauth;

	/**
	 * Catch all for Opauth
	 */
	public function index(){
		$this->_loadOpauth();
		$this->Opauth->run();

		return;
	}

	/**
	 * Receives auth response and does validation
	 */
	public function callback(){
		$response = null;

		/**
		 * Fetch auth response, based on transport configuration for callback
		 */
		$transport = 'session'; //defaults to post

		if (isset(Configure::read('Opauth.Config')['callback_transport'])) {
			$transport = Configure::read('Opauth.Config')['callback_transport'];
		}

		switch($transport){
			case 'session':
				if (!session_id()){
					session_start();
				}

				if(isset($_SESSION['opauth'])) {
					$response = $_SESSION['opauth'];
					unset($_SESSION['opauth']);
				}
				break;
			case 'post':
				$response = unserialize(base64_decode( $_POST['opauth'] ));
				break;
			case 'get':
				$response = unserialize(base64_decode( $_GET['opauth'] ));
				break;
			default:
				echo '<strong style="color: red;">Error: </strong>Unsupported callback_transport.'."<br>\n";
				break;
		}

		/**
		 * Check if it's an error callback
		 */
		if (isset($response) && is_array($response) && array_key_exists('error', $response)) {
			// Error
			$response['validated'] = false;
		}

		/**
		 * Auth response validation
		 *
		 * To validate that the auth response received is unaltered, especially auth response that
		 * is sent through GET or POST.
		 */
		else{
			$this->_loadOpauth();

			if (empty($response['auth']) || empty($response['timestamp']) || empty($response['signature']) || empty($response['auth']['provider']) || empty($response['auth']['uid'])){
				$response['error'] = array(
					'provider' => $response['auth']['provider'],
					'code' => 'invalid_auth_missing_components',
					'message' => 'Invalid auth response: Missing key auth response components.'
				);
				$response['validated'] = false;
			}
			elseif (!($this->Opauth->validate(sha1(print_r($response['auth'], true)), $response['timestamp'], $response['signature'], $reason))){
				$response['error'] = array(
					'provider' => $response['auth']['provider'],
					'code' => 'invalid_auth_failed_validation',
					'message' => 'Invalid auth response: '.$reason
				);
				$response['validated'] = false;
			}
			else{
				$response['validated'] = true;
			}
		}

		/**
		 * Redirect user to CompleteURL config
		 * with validated response data available as POST data
		 * retrievable at $this->data at your app's controller
		 */
		$Request = new Request(Configure::read('Opauth.CompleteURL'));
		$Request->data = $response;

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

		$config += [
			'path' => Router::url([ 'controller' => 'Opauth', 'action' => 'index' ]),
			'debug' => Configure::read('debug'),
			'callback_url' => Router::url([ 'controller' => 'Opauth', 'action' => 'callback' ]),
			'callback_transport' => 'session',
			'security_salt' => Configure::read('Security.salt'),
			'strategy_dir' => APP . 'Strategy',
			'strategy' => Configure::read('Opauth.Strategy')
		];

		$this->Opauth = new Opauth( $config );
	}
}
