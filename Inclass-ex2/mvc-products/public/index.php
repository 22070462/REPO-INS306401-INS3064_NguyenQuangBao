<?php
session_start();                    // để lưu sản phẩm tạm thời

require_once __DIR__ . '/../core/Router.php';

$router = new Router();

// Đăng ký 3 routes theo yêu cầu (yêu cầu 4)
$router->get('/products', 'ProductController@index');
$router->get('/products/create', 'ProductController@create');
$router->post('/products/create', 'ProductController@store');

$router->dispatch();
