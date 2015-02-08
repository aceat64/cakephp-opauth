CakePHP plugin for Opauth
=========================

CakePHP 3.x plugin for [Opauth](https://github.com/opauth/opauth).

Opauth is a multi-provider authentication framework.

Requirements
---------
- CakePHP >= v3.0
- Opauth >= v1.0

Using [Composer](http://getcomposer.org/)
-----------
You can install CakePHP-Opauth plugin directly from Composer at [wouter0100/cakephp-opauth](http://packagist.org/packages/wouter0100/cakephp-opauth).

How to use
----------
1. Install this plugin using Composer, add `"wouter0100/cakephp-opauth": "*"` to your Composer file and execute `composer update`.

2. Add this line to the bottom of your app's `config/bootstrap.php`:

   ```php
   Plugin::load('Wouter0100/Opauth', ['routes' => true, 'bootstrap' => true]);
   ```

3. Create a `config/opauth.php` file with the URL you wish to use for handeling the authentication data after opauth has run:

   ```php
   <?php

   $config['Opauth']['CompleteURL'] = '/auth/complete';
   ```
   You may want to add `config/opauth.php` to your gitignore, as the file will contain sensitive information.

4. Load [strategies](https://github.com/uzyn/opauth/wiki/list-of-strategies) using Composer for Opauth 1.0.0.

   Append configuration for strategies at your `config/opauth.php` file as follows:
   ```php
   // Using Facebook strategy as an example
   $config['Opauth']['Strategy']['Facebook'] = [
        'app_id' => 'YOUR FACEBOOK APP ID',
        'app_secret' => 'YOUR FACEBOOK APP SECRET'
   ];
   ```

5. Go to `/auth/facebook` to authenticate with Facebook, and similarly for other strategies that you have loaded.

6. After validation, user will be redirected to `'/auth/complete'` (or whatever you chose in the `opauth.php`
   config file) with validated auth response data retrievable available at `$this->response->data`.

   To route a controller to handle the response, at your app's `config/routes.php`, add a connector, for example:

   ```php
   $routes->connect(
       '/auth/complete',
       ['controller' => 'Users', 'action' => 'complete']
   );
   ```

   You can then work with the authentication data at, say `src/Controller/UsersController.php` as follows:
   
   ```php
   <?php
   namespace App\Controller;

   use App\Controller\AppController;

   class UsersController extends AppController
   {
       public function complete()
       {
           debug($this->request->data);
       }
   }
   ```

   Note that this CakePHP Opauth plugin already does auth response validation for you with its results available
   as a boolean value at `$this->request->data['validated']`.

Issues & questions
-------------------
- Discussion group: [Google Groups](https://groups.google.com/group/opauth)  
  _This is the primary channel for support, especially for user questions._
- Issues: [Github Issues](https://github.com/wouter0100/cakephp-opauth/issues)  
- Twitter: [@wouter0100](http://twitter.com/wouter0100)  
- Email me: wouter@wouter0100.nl
- IRC: **#opauth** on [Freenode](http://webchat.freenode.net/?channels=opauth&uio=d4)

<p>Used this plugin in your CakePHP project? Let us know!</p>

License
---------
The MIT License  
Copyright © 2012-2015 U-Zyn Chua (http://uzyn.com), further mentained by Wouter van Os (http://wouter0100.nl)
