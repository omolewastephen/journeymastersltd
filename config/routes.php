<?php
/**
 * Application routes.  $router is provided by app/bootstrap.php.
 * @var \App\Core\Router $router
 */

$router->get('/', 'PageController@home');
$router->get('/about', 'PageController@about');

$router->get('/services', 'ServiceController@index');
$router->get('/services/{slug}', 'ServiceController@show');

$router->get('/destinations', 'DestinationController@index');
$router->get('/destinations/{slug}', 'DestinationController@show');

$router->get('/blog', 'BlogController@index');
$router->get('/blog/{slug}', 'BlogController@show');

$router->get('/contact', 'ContactController@show');
$router->post('/contact', 'ContactController@submit');

$router->post('/newsletter', 'NewsletterController@subscribe');

/* ---- Admin ------------------------------------------------------------- */
$router->get('/admin/login', 'Admin\AuthController@showLogin');
$router->post('/admin/login', 'Admin\AuthController@login');
$router->get('/admin/logout', 'Admin\AuthController@logout');
$router->post('/admin/logout', 'Admin\AuthController@logout');

$router->get('/admin', 'Admin\DashboardController@index');

$router->get('/admin/messages', 'Admin\MessagesController@index');
$router->get('/admin/messages/{id}', 'Admin\MessagesController@show');
$router->post('/admin/messages/{id}/delete', 'Admin\MessagesController@destroy');

$router->get('/admin/subscribers/export', 'Admin\SubscribersController@export');
$router->get('/admin/subscribers', 'Admin\SubscribersController@index');
$router->post('/admin/subscribers/{id}/delete', 'Admin\SubscribersController@destroy');

$router->get('/admin/password', 'Admin\AccountController@edit');
$router->post('/admin/password', 'Admin\AccountController@update');

// SEO utilities
$router->get('/sitemap.xml', 'PageController@sitemap');
$router->get('/robots.txt', 'PageController@robots');
