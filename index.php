
<?php
/**
 * ETML
 * Auteur :  Theo Orlando
 * Date: 12.10.2022
 * Site web en MVC et orienté objet pour la gestion des surnoms des profs de l'ETML
 */

include_once 'controller/Controller.php';
include_once 'controller/IdeeController.php';


class MainController
{

    /**
     * Permet de sélectionner le bon contrôleur et l'action
     */
    public function dispatch()
    {
        if (!isset($_GET['controller'])) {
            $_GET['controller'] = 'idee';
            if(empty($_SESSION["login"])){
                $_GET['action'] = 'login';
            }else{
                $_GET['action'] = 'about';
            }
        }
        $currentLink = $this->menuSelected($_GET['controller']);
        $this->viewBuild($currentLink);
    }

    /**
     * Selectionner la page et instancier le contrôleur
     *
     * @param string $page : page sélectionnée
     * @return $link : instanciation d'un controller
     */
    protected function menuSelected($controller)
    {

        switch ($controller) {
            case 'Idee':
                $link = new IdeeController();
                break;
            default:
                $link = new IdeeController();
                break;
        }

        return $link;
    }

    /**
     * Construction de la page
     *
     * @param $currentPage : la page qui doit s'afficher
     */
    protected function viewBuild($currentPage)
    {
        $content = $currentPage->display();
        switch($_GET["action"]){
            case 'repository':
                $title = "Dépot d'idées";
                break;
            case 'priority':
                $title = 'Priorités';
                break;
            case 'analyse':
                $title = 'Analyse critique';
                break;
            case 'experiment':
                $title = 'Experimentation';
                break;
            case 'implement':
                $title = 'Implémentation';
                break;
            case 'login':
                $title = 'connexion';
                break;
            case 'signUp':
                $title = 'Inscription';
                break;
            case 'add':
                $title = 'ajouter';
                break;
            case 'edit':
                $title = 'changement';
                break;
            default:
                $title = 'Site des Idées';
                break;
        }
        
        include(dirname(__FILE__) . '/view/head.php');
        include(dirname(__FILE__) . '/view/header.php');
        echo $content;
        include(dirname(__FILE__) . '/view/footer.html');
    }
}

$controller = new MainController();
$controller->dispatch();