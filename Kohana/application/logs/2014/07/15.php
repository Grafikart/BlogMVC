<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2014-07-15 08:42:47 --- EMERGENCY: ErrorException [ 2048 ]: Non-static method Auth::logout() should not be called statically, assuming $this from incompatible context ~ APPPATH/classes/Controller/Admin.php [ 42 ] in /var/www/public/Kohana/application/classes/Controller/Admin.php:42
2014-07-15 08:42:47 --- DEBUG: #0 /var/www/public/Kohana/application/classes/Controller/Admin.php(42): Kohana_Core::error_handler(2048, 'Non-static meth...', '/var/www/public...', 42, Array)
#1 /var/www/public/Kohana/system/classes/Kohana/Controller.php(84): Controller_Admin->action_logout()
#2 [internal function]: Kohana_Controller->execute()
#3 /var/www/public/Kohana/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Admin))
#4 /var/www/public/Kohana/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#5 /var/www/public/Kohana/system/classes/Kohana/Request.php(986): Kohana_Request_Client->execute(Object(Request))
#6 /var/www/public/Kohana/index.php(118): Kohana_Request->execute()
#7 {main} in /var/www/public/Kohana/application/classes/Controller/Admin.php:42