<?php

/**
 * 
 *  @name : CreateCategoryC.php
 *  
 *  @brief :  create a category page
 * 
 * 
 */



// required models
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/Category.php';

session_start();

 class CreateCategoryC {


    /**
     *  @name : displayPage
     *  @param : void
     * 
     *  @return : void
     *
     * 
     */
    public function displayPage() {

        if (!empty($_POST['submit'])) {
            if (empty($_POST['categName']) || strlen($_POST['categName']) > 20) {
                $_SESSION['popup'] = new PopUp('error', 'Impossible d\'avoir une catégorie sans nom ou supérieure à 20 caractères.');
                header('location:/php/createcategory');
                exit();
            }

            $newCategory = new Category(null, $_POST['categName'], $_SESSION['user']->getUser_id(), null);
            $newCategId = $newCategory->save();

            $_SESSION['popup'] = new PopUp('success', 'La catégorie '.$_POST['categName'].' a bien été créée.');
            header('location:/php/category?category='.$newCategId);
            exit();

        }

        View::render('Category/createCategory');

    }// public function createCar()

}
