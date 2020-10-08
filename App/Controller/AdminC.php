<?php

/**
 * 
 *  @name : AdminC.php
 *  
 *  @brief :  Admin controller pages
 * 
 */



// required models
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/User.php';
require_once __DIR__.'/../Model/Category.php';

// session_start ?
session_start();

 class AdminC {

    function __construct() {
        if (empty($_SESSION['user'])) {
            $_SESSION['popup'] = new PopUp('error', 'L\'article recherché n\'existe pas');
            header('location:/php/error?error=404');
            exit();
        }

        if ($_SESSION['user']->getRank() != 'admin'){
            $_SESSION['popup'] = new PopUp('error', 'L\'utilisateur doit etre administrateur');
            header('location: /PHP/');
            exit;
        }

    } // function __construct

    /**
     *  @name : DisplayAdminPage

     *  @param : void
     * 
     *  @return : void
     *
     * 
     */
    public function DisplayAdminPage() {
        
        // Check user rank 
        $users = User::getUsers();


        // Ban User
        if(!empty($_POST)) {
            if ($_POST['submit'] == 'ban') {
                $userC = User::getUser($_POST['userid']);
                if(!$userC){
                    $_SESSION['popup'] = new PopUp('error', 'L\'utilisateur n\'existe pas');
                    header('location:/php/admin');
                    exit();                 
                }
                User::ChangeUserStatus($_POST['userid'],3);
                
                
            } else if ($_POST['submit'] == 'désactiver') {
                $userC = User::getUser($_POST['userid']);
                if(!$userC){
                    $_SESSION['popup'] = new PopUp('error', 'L\'utilisateur n\'existe pas');
                    header('location:/php/admin');
                    exit();                 
                }
                User::ChangeUserStatus($_POST['userid'],2);
            
            } else if ($_POST['submit'] == 'activ') {
                $userC = User::getUser($_POST['userid']);
                if(!$userC){
                    $_SESSION['popup'] = new PopUp('error', 'L/utilisateur n/existe pas');
                    header('location:/php/admin');
                    exit();                 
                }
                User::ChangeUserStatus($_POST['userid'],1);
            } 

            $_SESSION['popup'] = new PopUp('success', 'L\'utilisateur a été mit à jour');
            header('location:/php/admin');
            exit();
        }


        View::render('Admin/Admin', ['users' => $users]);

    }//   public function DisplayPage

}
