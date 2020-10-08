<?php

/**
 * 
 *  @name : UserHomePageC.php
 *  
 *  @brief :  UserHomePage controller pages
 * 
 * 
 */


require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/User.php';

// session_start ?
session_start();


 class UserHomePageC {


    /**
     *  @name : DisplayUserPage
     *  @param : void
     * 
     *  @return : void
     *
     * 
     */     
    public function DisplayUserPage() {
        
        view::render('User/HomePage');

    }// public function DisplayUserPage()

}
