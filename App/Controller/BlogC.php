<?php

/**
 * @title : BlogC.php
 * 
 * @name : blog page controllers
 * 
 */
require_once __DIR__.'/../Model/User.php';
require_once __DIR__.'/../Model/Information.php';
require_once __DIR__.'/../Model/Follow.php';
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/Category.php';

session_start();

class BlogC {

    function __construct() {
        if(empty($_SESSION['user'])) {
            $_SESSION['popup'] = new PopUp('error', 'Vous devez être connecté pour accéder à cette page');
            header('location:/php/connexion');
            exit();
        }

    } // function __construct()

    public function displayPage() {
        if (empty($_GET['user'])) {
            $_SESSION['popup'] = new PopUp('error', 'La categorie n\'est pas renseignée');
            header('location:/php/error?error=403');
            exit();
        }
        
        $user = User::getUser($_GET['user']);
        if (!$user) {
            $_SESSION['popup'] = new PopUp('error', 'La categorie n\'existe pas.');
            header('location:/php/error?error=403');
            exit();
        }
        

        if($_SESSION['user']->getUser_id() == $_GET['user']) {
            header('location:/php/myblog');
            exit();
        }

        $user->setBlog();
        $user->setUserFollower();
        $user->setUserFollowing();


        if (!empty($_POST)) {
            $user->setFollow($_GET['user']);
            $_SESSION['popup'] = new PopUp('success', 'Action effectuée.');
            header('location:/php/blog?user='.$_GET['user']);
            exit();   
        }

        View::render('Blog/displayBlog', ['user' => $user]);

    } // public function displayPage


    public function displayMyBlog() {
        $user = $_SESSION['user'];
            
        $user->setBlog();
        $user->setUserFollower();
        $user->setUserFollowing();

        View::render('Blog/myBlog', ['user' => $user]);
    }

}


?>