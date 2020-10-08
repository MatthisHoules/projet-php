<?php

/**
 * 
 *  @name : MailC.php
 *  
 *  @brief :  Mail controller page
 * 
 * 
 */



// required models
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/User.php';
require_once __DIR__.'/../Model/SourceFrom/MailInfo.php';
require_once __DIR__.'/../Model/Category.php';
require_once __DIR__.'/../Model/Source.php';

// session_start ?
session_start();

 class MailC {


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
     */
    public function displayPage() {


        // form traitment
        if (!empty($_POST)) {
            $arrayImap = array_keys(MailInfo::IMAP);

            if (empty($_POST['mailType']) || !in_array($_POST['mailType'], $arrayImap)) {
                $_SESSION['popup'] = new PopUp('error', 'Fournisseur de votre email non valide.');
                header('location:/php/addmail?category='.$_GET['category']);
                exit();
            }
            if(empty($_POST['password'])) {
                $_SESSION['popup'] = new PopUp('error', 'Votre mot de passe est requis.');
                header('location:/php/addmail?category='.$_GET['category']);
                exit();
            }

            if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['popup'] = new PopUp('error', 'Le champs email doit être renseigné et être une adresse email valide.');
                header('location:/php/addmail?category='.$_GET['category']);
                exit();
            }

            $request = '';
            if (!empty($_POST['authorFrom'])) {
                if (!filter_var($_POST['authorFrom'], FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['popup'] = new PopUp('error', 'L\'email de l\'auteur des mails doit être une adresse email valide');
                    header('location:/php/addmail?category='.$_GET['category']);
                    exit();
                } else {
                    $request .= 'FROM "'.htmlspecialchars($_POST['authorFrom']).'"';
                }
            }

            if (!empty($_POST['subjectFrom'])) {
                $request .= ' SUBJECT "'.htmlspecialchars($_POST['subjectFrom']).'"';
            }

            if (strlen($request) == 0) {
                $_SESSION['popup'] = new PopUp('error', 'Il faut au moins rentrer le sujet ou une provenance des mails.');
                header('location:/php/addmail?category='.$_GET['category']);
                exit();
            }

            $imap = MailInfo::connectIMAP($_POST['mailType'], $_POST['email'], $_POST['password'], $request);
            if (!$imap) {
                $_SESSION['popup'] = new PopUp('error', 'Impossible de vous connecter à votre adresse mail');
                header('location:/php/addmail?category='.$_GET['category']);
                exit();
            }

            $imap->save();

            $_SESSION['popup'] = new PopUp('success', 'La source a été ajoutée avec succès.');
            header('location:/php/editcategory?category='.$_GET['category']);
            exit();

        }

        $category = Category::getCategory($_GET['category']);

        View::render('Category/addMail', ['category' => $category]);
    }// public function createCar()

}
