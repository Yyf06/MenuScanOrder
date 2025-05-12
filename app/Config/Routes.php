<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//customer 



$routes->get('login', 'BusinessownerController::login');
$routes->post('login', 'BusinessownerController::loginAuth');
$routes->get('signup', 'BusinessownerController::signUp');
$routes->post('signup', 'BusinessownerController::register');
$routes->get('businessowner/logout', 'BusinessownerController::logout');


//Menu management
$routes->get('menu_management', 'BusinessownerController::menuManagement');
$routes->get('menu_management/add_item', 'BusinessownerController::addedit');
$routes->post('menu_management/add_item', 'BusinessownerController::additem_submit');
$routes->get('menu_management/delete_item/(:num)', 'BusinessownerController::deleteItem/$1');

$routes->get('menu_management/view_item/(:num)', 'BusinessownerController::viewItem/$1');
$routes->get('menu_management/edit_item/(:num)', 'BusinessownerController::editItem/$1');
$routes->post('menu_management/update_item/(:num)', 'BusinessownerController::updateItem/$1');

$routes->post('menu_management/search', 'BusinessownerController::search');
$routes->post('menu_management/generate_ai_description/(:num)', 'BusinessownerController::generateAIDescription/$1');
    

$routes->get('menu_management/category_management', 'BusinessownerController::categoryManagement');
$routes->post('menu_management/category_management', 'BusinessownerController::addCategory');
$routes->post('menu_management/category_management/delete/(:num)', 'BusinessownerController::deleteCategory/$1');

//Order management
$routes->get('order_management', 'BusinessownerController::orderManagement');

$routes->get('order_management/pendingOrder', 'BusinessownerController::pendingOrder');
$routes->get('order_management/pastOrder', 'BusinessownerController::pastOrder');
$routes->get('order_management/pastOrder/delete/(:num)', 'OrderController::delete/$1');

//QR
$routes->get('qrcode', 'BusinessownerController::qrGenerator');


//google
$routes->get('/googlelogin', 'Auth::google_login');  // Route to initiate Google login
$routes->get('/googlelogin/callback', 'Auth::google_callback');  // Callback route after Google auth
$routes->get('/googlelogout', 'Auth::logout'); 

//admin
$routes->get('admin', 'AdminController::index'); 
$routes->post('admin/adduser', 'AdminController::addUser');
$routes->post('/admin/alterpassword', 'AdminController::alterPassword');

$routes->get('/admin/edit_user/(:num)', 'AdminController::editUser/$1');
$routes->post('admin/update_user/(:num)', 'AdminController::updateUser/$1');
$routes->get('/admin/delete_user/(:num)', 'AdminController::deleteUser/$1');
$routes->get('/adminlogout', 'AdminController::logout'); 

//google login for customer
$routes->get('/(:segment)/(:segment)/(:num)', 'CustomerController::index');
$routes->get('/customer/(:segment)/(:segment)', 'CustomerController::index');


$routes->post('/(:segment)/(:segment)/login', 'CustomerController::loginAuth');

//landing through qr code
$routes->get('/(:num)/orderconfirm', 'CustomerController::confirmOrder/$1');
$routes->get('/(:segment)/(:segment)', 'CustomerController::QR_index/$1/$2');
$routes->get('/(:segment)/(:segment)/orderconfirm', 'CustomerController::placeOrder/$1/$2');

$routes->get('/(:segment)/(:segment)/customer_signup', 'CustomerController::signUp');
$routes->post('/(:segment)/(:segment)/customer_signup', 'CustomerController::customer_signUp');


$routes->get('/(:segment)/(:segment)/login', 'CustomerController::login');  
$routes->post('login/(:segment)/(:segment)/', 'CustomerController::loginAuth');

$routes->get('/(:segment)/(:segment)/customer/logout', 'CustomerController::logout');


$routes->get('/landing', 'BusinessownerController::landing');
