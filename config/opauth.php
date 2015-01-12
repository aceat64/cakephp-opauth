<?php

use Cake\Core\Configure;

/**
 * CakePHP plugin for Opauth, example config file
 *
 * @copyright    Copyright © 2012-2013 U-Zyn Chua (http://uzyn.com), 2015 Wouter van Os (http://wouter0100.nl)
 * @link         http://opauth.org
 * @license      MIT License
 */

/**
 * Overwrite default OPauth config
 * For all configuration variables see:
 * https://github.com/opauth/opauth/wiki/Opauth-configuration
 */
Configure::write('Opauth.Config', []);

/**
 * Complete URL to dispatch after an authentication has been done (success or failed).
 */
Configure::write('Opauth.CompleteURL', '/auth/complete');

/**
 * Strategy
 * Refer to individual strategy's documentation on configuration requirements.
 *
 * Add strategy configurations in your app's bootstrap.php in the following format:
 *
 * Configure::write('Opauth.Strategy.Facebook', array(
 *     'app_id' => 'YOUR FACEBOOK APP ID',
 *     'app_secret' => 'YOUR FACEBOOK APP SECRET'
 * ));
 *
 */
Configure::write('Opauth.Strategy', []);