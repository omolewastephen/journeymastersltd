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

// SEO utilities
$router->get('/sitemap.xml', 'PageController@sitemap');
$router->get('/robots.txt', 'PageController@robots');
