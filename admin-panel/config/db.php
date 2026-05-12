<?php

return [
    'dsn' => sprintf(
        'mysql:host=%s;dbname=%s;charset=%s', 
        Enviroment::get('DB_HOST'), 
        Enviroment::get('DB_NAME'), 
        Enviroment::get('DB_CHARSET')
        ),
    'user' => Enviroment::get('DB_USER'),
    'pass' => Enviroment::get('DB_PASS'),
];

?>