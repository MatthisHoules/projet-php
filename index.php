<?php
/**
 *  @title : index.php
 * 
 *  @brief : Routing table & start page
 */

// require Core files
require_once './Core/Model.php';
require_once './Core/View.php';

date_default_timezone_set('Europe/Paris');

// Router
require_once './Core/Router.php';
$Router = new Router;


/**
 *  Add your routes here
 */

/**
 * How to add a route :
 * $router->add(URL, ['controller' => ControllerPage@MethodName]);
 */
$Router->add('/php/category', ['controller' => 'CategoryC@displayPage']);
$Router->add('/php/editcategory', ['controller' => 'EditCategoryC@displayPage']);
$Router->add('/php/createcategory', ['controller' => 'CreateCategoryC@displayPage']);

// mail
$Router->add('/php/addmail', ['controller' => 'MailC@displayPage']);

// fav & blog 
$Router->add('/php/fav', ['controller' => 'CategoryC@favPage']);
$Router->add('/php/blog', ['controller' => 'BlogC@displayPage']);


// article
$Router->add('/php/article', ['controller' => 'ArticleC@displayPage']);


// user
$Router->add('/php/connexion', ['controller' => 'UserC@signIn']);
$Router->add('/php/inscription', ['controller' => 'UserC@signUp']);
$Router->add('/php/editerprofil', ['controller' => 'UserC@editProfile']);
$Router->add('/php/changepwdm', ['controller' => 'UserC@changePasswordMail']);
$Router->add('/php/changepwdc', ['controller' => 'UserC@changePasswordCode']);
$Router->add('/php/validation', ['controller' => 'UserC@validateAccount']);
$Router->add('/php/homepage',['controller' => 'UserHomePageC@DisplayUserPage']); 
$Router->add('/php/deconnexion', ['controller' => 'SignOutC@signOut']);

// admin
$Router->add('/php/myblog', ['controller' => 'BlocC@displayMyBlog']);
$Router->add('/php/admin',['controller' => 'AdminC@DisplayAdminPage']);


// Initialize Controller
$Router->initialize();


?>