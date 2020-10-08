<?php

/**
 * 
 *  @name : SignOutC.php
 *  
 *  @brief :  signOut controller pages
 * 
 * 
 */



// required models
require_once __DIR__ .'/../../Core/PopUp.php';
require_once __DIR__ .'/../Model/User.php';

// session_start ?
session_start();

 class SignOutC {

    /**
     *  @name : signOut
     *  
     *  @param void
     *  
     *  @return void
     * 
     *  @brief : log out page controller
     */
    public function signOut() {
        unset($_SESSION['user']);
        
        $_SESSION['popup'] = new PopUp('success', 'Vous êtes maintenant déconnecté.');
        header('location: /php/connexion');




    } // public function signOut()

}
