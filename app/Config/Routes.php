<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setAutoRoute(false);

$routes->get('/', 'Home::index'); // Landing page
$routes->get('login', 'Auth::login'); // Login page
$routes->post('login', 'Auth::doLogin'); // Handle login
$routes->get('register', 'Auth::register'); // Register page
$routes->post('register', 'Auth::doRegister'); // Handle registration
$routes->get('logout', 'Auth::logout'); // Logout
$routes->get('dashboard', 'Admin::index'); // Admin dashboard
$routes->get('posts/create', 'Post::create'); // Create post page
$routes->post('posts/store', 'Post::store'); // Save post
$routes->get('posts/edit/(:num)', 'Post::edit/$1'); // Edit post page
$routes->post('posts/update/(:num)', 'Post::update/$1'); // Update post
$routes->post('posts/delete/(:num)', 'Post::delete/$1'); // Delete post
$routes->get('posts', 'Blog::index'); // Blog homepage
$routes->get('posts/(:num)', 'Blog::view/$1'); // Single post
$routes->get('author/(:num)', 'Blog::author/$1'); // Author’s posts