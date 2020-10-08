<?php

/**
 * 
 *  @name : ArticleC.php
 *  
 *  @brief :  Article controller pages
 * 
 * 
 */



// required models
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/Information.php';
require_once __DIR__.'/../Model/User.php';
require_once __DIR__.'/../Model/Category.php';

// session_start ?
session_start();

 class ArticleC {


    function __construct() {
        if (empty($_GET['article'])) {
            $_SESSION['popup'] = new PopUp('error', 'L\'article recherché n\'existe pas');
            header('location:/php/error?error=404');
            exit();
        }

    } // function __construct()


    /**
     *  @name : displayPage
     *  @param : void
     * 
     *  @return : void
     *
     * 
     */
    public function displayPage() {
        $article = Information::getInformationById($_GET['article']);

        if (!$article) {
            $_SESSION['popup'] = new PopUp('error', 'L\'article recherché n\'existe pas');
            header('location:/php/error?error=404');
            exit();
        }

        View::render('Article/Article', ['article' => $article]);

    } // public function displayPage()

}
