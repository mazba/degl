<?php
use Cake\Routing\Router;

Router::plugin('Shaiful', function ($routes) {
    $routes->fallbacks('InflectedRoute');
});
