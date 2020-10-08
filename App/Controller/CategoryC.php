<?php

/**
 * 
 *  @name : CategoryC.php
 *  
 *  @brief :  Category display and fav pages controller
 * 
 * 
 */



// required models
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/Category.php';
require_once __DIR__.'/../Model/Source.php';

// session_start ?
session_start();

 class CategoryC {

    /**
     * @name : __construct
     * 
     * @brief : middleware user connected & category exist & belongs to user
     * 
     */
    function __construct() {
        if(empty($_SESSION['user'])) {
            $_SESSION['popup'] = new PopUp('error', 'Vous devez être connecté pour accéder à cette page');
            header('location:/php/connexion');
            exit();
        }

        if (empty($_GET['category'])) {
            $_SESSION['popup'] = new PopUp('error', 'La categorie n\'est pas renseignée');
            header('location:/php/error?error=403');
            exit();
        }

        if (!Category::categoryBelongsToUser($_SESSION['user']->getUser_id(), $_GET['category'])) {
            $_SESSION['popup'] = new PopUp('error', 'La categorie ne vous appartient pas'   );
            header('location:/php/error?error=403');
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
        // FORM TRAITMENTS
        if (!empty($_POST)) {
            if (empty($_POST['submit']) || empty($_POST['id'])) {
                $_SESSION['popup'] = new PopUp('error', 'Erreur serveur, veuillez réessayer.');
                header('location:/php/category?category='.$_GET['category']);
                exit();
            }

            if (!Information::InformationBelongsToCategory($_POST['id'], $_GET['category']))  {

                $_SESSION['popup'] = new PopUp('error', 'Erreur serveur, veuillez réessayer.');
                header('location:/php/category?category='.$_GET['category']);
                exit();
            }


            if ($_POST['submit'] == 'read') {
                Information::setIsRead($_POST['id'], 1);
                $_SESSION['popup'] = new PopUp('success', 'l\'information a été marquée comme lue.');

            } else if ($_POST['submit'] == 'fav') {

                Information::setFav($_POST['id'], 1);
                Information::setIsRead($_POST['id'], 1);

                $_SESSION['popup'] = new PopUp('success', 'L\'information ajoutée aux favoris de la catégorie et marquée comme lue.');

            } else if ($_POST['submit'] == 'blog') {

                Information::setBlog($_POST['id'], 1);
                Information::setIsRead($_POST['id'], 1);

                $_SESSION['popup'] = new PopUp('success', 'L\'information ajoutée à votre blog et marquée comme lue.');
            } else {

                $_SESSION['popup'] = new PopUp('error', 'Erreur serveur, veuillez réessayer.');
            }
            header('location:/php/category?category='.$_GET['category']);
            exit();
        }

        $category = Category::getCategory($_GET['category']);
        $category->setListInformationsDisplay();


        View::render('Category/displayCategory', ['category' => $category]);
    }// public function displayPage()


    /**
     * 
     * @name : favPage
     * @param : void
     * 
     * @return : void
     * 
     */
    public function favPage() {

        // FORM TRAITMENT
        if (!empty($_POST)) {
            if (empty($_POST['submit']) || empty($_POST['id'])) {
                $_SESSION['popup'] = new PopUp('error', 'Erreur serveur, veuillez réessayer.');
                header('location:/php/fav?category='.$_GET['category']);
                exit();
            }

            if (!Information::InformationBelongsToCategory($_POST['id'], $_GET['category']))  {

                $_SESSION['popup'] = new PopUp('error', 'Erreur serveur, veuillez réessayer.');
                header('location:/php/fav?category='.$_GET['category']);
                exit();
            }

            if ($_POST['submit'] == 'fav') {

                Information::setFav($_POST['id'], 0);

                $_SESSION['popup'] = new PopUp('success', 'L\'information a été supprimée des favoris.');

            }
            header('location:/php/fav?category='.$_GET['category']);
            exit();
        }


        $category = Category::getCategory($_GET['category']);
        $category->setListInformationsFav();

        View::render('Category/displayCategoryFav', ['category' => $category]);
    } // public function favPage  
    
}



