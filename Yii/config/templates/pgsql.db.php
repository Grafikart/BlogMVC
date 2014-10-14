<?php
// replace %database-name%, %username% and %password% with corresponding values
return array(
    // unix-socket connection
    'connectionString' => 'pgsql:dbname=%database-name%',
    // network connection
    // 'connectionString' => 'pgsql:host=localhost;port=5432;dbname=%database-name%',
    'username' => '%username%',
    'password' => '%password%',
);
