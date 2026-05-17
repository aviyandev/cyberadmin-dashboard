<?php

return [
    'enabled' => true,
    'route_prefix' => 'cyberadmin',
    'middleware' => ['web', 'auth', 'setLocale'],
];
