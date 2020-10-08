<?php


/**
 * 
 * @title : EditCategoryC.php
 * 
 * @brief : Edit Category class 
 * 
 */
require_once __DIR__.'/../../Core/PopUp.php';
require_once __DIR__.'/../Model/Category.php';
require_once __DIR__.'/../Model/Source.php';
require_once __DIR__.'/../Model/Information.php';

session_start();


class EditCategoryC {

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


    public function displayPage() {

        $category = Category::getCategory($_GET['category']);
        
        // FORM traitment
        if (!empty($_POST)) {
            // ajout source twitter
            if (isset($_POST['twitterSource'])) {

                if (empty($_POST['twitterType']) || empty($_POST['value']) || empty($_POST['name'])) {
                    
                    $_SESSION['popup'] = new PopUp('error', 'Erreur serveur, veuillez réessayer.');
                    header('location:/php/editcategory?category='.$_GET['category']);
                    exit();
                } else {
                
                    if ( $_POST['twitterType'] == 'hashtag' && $_POST['value'][0]  != '#') {
                        $_POST['value'] = '#'.$_POST['value'];

                    } else if ($_POST['twitterType'] == 'account' && $_POST['value'][0]  != '@') {
                        $_POST['value'] = '@'.$_POST['value'];
                    }

                    $newSource = new Source(null, 'TWITTER', htmlspecialchars($_POST['value']), htmlspecialchars($_POST['name']));
                    $newSource->save();

                    $_SESSION['popup'] = new PopUp('success', 'Source ajoutée.');
                    header('location:/php/editcategory?category='.$_GET['category']);
                    exit();
                }  
        
            }


            // ajout source rss
            if (isset($_POST['rssSource'])) {
                if (empty($_POST['name']) || empty($_POST['value']) ||  !filter_var($_POST['value'], FILTER_VALIDATE_URL)) {
                    $_SESSION['popup'] = new PopUp('error', 'Le nom doit être remplie et la valeur doit être un URL.');
                    header('location:/php/editcategory?category='.$_GET['category']);
                    exit();
                }

                $tryFile = simplexml_load_file($_POST['value'], 'SimpleXMLElement', LIBXML_NOWARNING);
                if (!$tryFile || $tryFile->getName() != 'rss') {
                    $_SESSION['popup'] = new PopUp('error', 'Le lien n\'existe pas ou n\'est pas RSS.');
                    header('location:/php/editcategory?category='.$_GET['category']);
                    exit();
                }

                $newSource = new Source(null, 'RSS', htmlspecialchars($_POST['value']), htmlspecialchars($_POST['name']));
                $newSource->save();

                $_SESSION['popup'] = new PopUp('success', 'Source ajoutée.');
                header('location:/php/editcategory?category='.$_GET['category']);
                exit();
            }


            // supprimer source
            if (isset($_POST['deleteSource'])) {
                if (empty($_POST['id']) || !Source::SourceBelongsUser($_POST['id'], $_SESSION['user']->getUser_id())) {
                    $_SESSION['popup'] = new PopUp('error', 'Impossible, la source ne vous impartient pas.');
                    header('location:/php/editcategory?category='.$_GET['category']);
                    exit();
                }

                Source::delete($_POST['id']);
                $_SESSION['popup'] = new PopUp('success', 'Source supprimée.');
                header('location:/php/editcategory?category='.$_GET['category']);
                exit();
            }


            // supprimer category
            if (isset($_POST['deleteCateg'])) {
                Category::delete($_GET['category']);

                $_SESSION['popup'] = new PopUp('success', 'Categorie supprimée.');
                header('location:/php/');
                exit();

            }

        }


        View::render('Category/EditCategory', ['category' => $category]);
    } // public function displayPage()

}