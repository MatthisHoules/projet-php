<?php

/**
 * 
 *  @name : HomepageC.php
 *  
 *  @brief :  Example controller pages
 * 
 * 
 */

// required models
require_once __DIR__.'/../Model/User.php';
require_once __DIR__.'/../../Core/PopUp.php';


// session_start
session_start();

 class HomepageC {


    /**
     *  @name : homepage
     *  @param : void
     * 
     *  @return : void
     *
     */
    public function homepage() {
        echo 'slt';

        var_dump(User::getUsers());


    }// public function createCar()

}
