<?php

use Cake\Core\Configure;

/**
 * CakePHP plugin for Opauth, example config file
 *
 * @copyright    Copyright © 2012-2013 U-Zyn Chua (http://uzyn.com), 2015 Wouter van Os (http://wouter0100.nl)
 * @link         http://opauth.org
 * @license      MIT License
 */

$config = [];
$config['Opauth'] = [];

/**
 * Overwrite default OPauth config
 * For all configuration variables see:
 * https://github.com/opauth/opauth/wiki/Opauth-configuration
 */
$config['Opauth']['Config'] = [];

/**
 * Complete URL to dispatch after an authentication has been done (success or failed).
 */
$config['Opauth']['CompleteURL'] = '/auth/complete';

/**
 * Strategy
 * Refer to individual strategy's documentation on configuration requirements.
 *
 * Add strategy configurations in your opauth.php file in the following format:
 *
 * $config['Opauth']['Strategy']['Facebook'] = [
 *     'app_id' => 'YOUR FACEBOOK APP ID',
 *     'app_secret' => 'YOUR FACEBOOK APP SECRET'
 * ];
 *
 */
$config['Opauth']['Strategy'] = [];
