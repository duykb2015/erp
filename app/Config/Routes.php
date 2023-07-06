<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('/', ['filter' => 'login'], function ($routes) {
    $routes->get('', 'Home::index');
});

$routes->group('auth', function ($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('login', 'Auth::checkLogin');

    $routes->get('register', 'Auth::register');
    $routes->post('register', 'Auth::checkRegister');

    $routes->get('logout', 'Auth::logout');
});

$routes->group('user', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'User::index');

    $routes->post('/', 'User::update');
    $routes->post('image/upload', 'User::upload');
    $routes->post('image/cancel', 'User::cancelUpload');
    $routes->post('image/remove', 'User::remove');
});

$routes->group('project', ['filter' => 'login'], function ($routes) {
    $routes->get('/', 'Project::list');
    $routes->post('create', 'Project::create');
    $routes->post('delete/(:num)', 'Project::delete');
    $routes->post('find/user', 'Project::findUser');
    $routes->post('(:num)/image/upload', 'Project::upload');
    $routes->post('(:num)/image/cancel', 'Project::cancelUpload');
    $routes->post('(:num)/image/remove', 'User::remove');

    $routes->get('(:num)/task/(:num)', 'Project::task');

    $routes->group('(:any)', function ($routes) {
        $routes->get('/', 'Project::detail');
        $routes->get('user', 'Project::user');
        $routes->post('user', 'Project::addUser');
        $routes->get('setting', 'Project::setting');
        $routes->post('setting', 'Project::saveSetting');
    });
});

$routes->group('section', ['filter' => 'login'], function ($routes) {
    $routes->get('create', 'Section::create');
    $routes->post('create', 'Section::create');
    $routes->post('update', 'Section::update');
    $routes->post('delete', 'Section::delete');
});

$routes->group('task', ['filter' => 'login'], function ($routes) {
    $routes->post('create', 'Task::create');
    $routes->post('update', 'Task::update');
    $routes->post('delete', 'Task::delete');

    $routes->post('change-status', 'Task::changeStatus');
});

$routes->group('upload', ['filter' => 'login'], function ($routes) {
    $routes->group('task', function ($routes) {
        $routes->post('attachment', 'Upload::task_attachment');
    });
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
