<?php

/**
 * 
 *  @name : CategoryC.php
 *  
 *  @brief :  Categories controller pages
 * 
 * 
 */



// required models
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../../Core/TwitterApi.php';
require_once __DIR__.'/../Model/Category.php';
require_once __DIR__.'/../Model/TwitterInformation.php';

// session_start ?
session_start();

class CategoryC {

    /**
     *  @name : displayPage
     *  @param : void
     * 
     *  @return : void
     *
     * 
     */
    public function displayPage() {
        if (!isset($_GET['category'])) {
            echo('no categ get param');
            die();
        }
        
        $api = new TwitterApi();

        $category = Category::getCategory($_GET['category']);
        
        $listInformations = array();


        foreach ($category->getListSources() as $key => $value) {
            $informations = $value->retreiveInformations();
            foreach ($informations as $key => $value) {
                array_push($listInformations, $value);
            }
        }

        // Sort informations recent to old
        function cmp($a, $b) {
            return strcmp($b->getDateC(), $a->getDateC());
        }
        usort($listInformations, "cmp");


        View::render('Category/displayCategory', ['category' => $category,
                                                    'listInformations' => $listInformations
                                                   ]);
        exit();
        
    }// public function displayPage()

}
