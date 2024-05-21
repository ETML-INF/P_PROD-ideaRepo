<?php
session_start();

/*
 * Auteurs: Maël Gétain, Theo Orlando
 * Date: 17.01.2024
 * Description: Controler pour gérer les idées
 * Copyright (c) 2024 ETML
 */


include_once './repository/IdeeRepository.php';

class IdeeController extends Controller {

    public function display() {

        $action = $_GET['action'] . "Action";

        // Appelle une méthode dans cette classe (ici, ce sera le nom + action (ex: listAction, detailAction, ...))
        return call_user_func(array($this, $action));
    }

    private function aboutAction()
    {
        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/about.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);
        // ob_get_clean permet de reprendre la lecture qui avait été stoppée (dans le but d'afficher la vue)
        $content = ob_get_clean();

        return $content;
    }
    
    /**
     * Récupère les informations de base pour tout les idées
     * 
     * @return $content : la page liste du site
     */
    private function listAction() {
        $ideeRepository = new IdeeRepository();
        $states = $ideeRepository->getAllStates();
        $categories = $ideeRepository->getAllCategories();
        $likedElements = $ideeRepository->getLikedElement($_SESSION["id"]);
        
        $string = $likedElements[0]["acc_liked"];

        $elements = explode(',', $string);

        // Instancie le modèle et va chercher les informations
        $idees = $ideeRepository->getIdea($_SESSION["sortCategory"], $_SESSION["sortState"]);

        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/list.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);
        // ob_get_clean permet de reprendre la lecture qui avait été stoppée (dans le but d'afficher la vue)
        $content = ob_get_clean();

        return $content;
    }

    /**
     * récupère tout les sports possible et appele la page d'ajout de sportif
     * 
     * @return $content : la page d'ajout de sportif
    */
    private function addAction() {
        $ideeRepository = new IdeeRepository();
        $categories = $ideeRepository->getAllCategories();
        $priorities = $ideeRepository->getAllPriorities();
        $_SESSION["title"] = NULL;
        $_SESSION["category"] = NULL;
        $_SESSION["description"] = NULL;
        $_SESSION["target"] = NULL;
        $_SESSION["priority"] = NULL;
        $_SESSION["image"] = NULL;
        $_SESSION["image2"] = NULL;

        if(!empty($_POST)){
            $tmp_name = $_FILES['files']['tmp_name'];
            $file_size = $_FILES['files']['size'];
            $file_type = $_FILES['files']['type'];

            
            $valid = true;
            //controle titre
            $title = $_POST["title"];
            if(!isset($title) || empty($title) || !preg_match("/^(.){1,255}$/", $title)){
                $_SESSION["title"] = "le titre doit faire au maximum 255 caractères";
                $valid = false;
            }
            $category = $_POST["category"];
            if(!isset($category) || empty($category)){
                $valid = false;
            }
            $validCategory = false;
            foreach($categories as $cat)
            {
                if($_POST["category"] == $cat["cat_id"]){
                    $validCategory = true;
                }
            }
            if($validCategory != true){
                $valid = false;
                $_SESSION["category"] = "choisisez une catégories existantes";
            }
            $validPriority = false;
            foreach($priorities as $priority)
            {
                if($_POST["priority"] == $priority["pri_id"]){
                    $validPriority = true;
                }
            }
            if($validPriority != true){
                $valid = false;
                $_SESSION["priority"] = "choisisez une priorités existantes";
            }
            $description = $_POST["description"];
            if(!isset($description) || empty($description) || !preg_match("/^(.){1,1000}$/", $description)){
                $_SESSION["description"] = "la description doit faire au maximum 1000 caractères";
                $valid = false;
            }
            $target = $_POST["cible"];
            if(!isset($target) || empty($target) || !preg_match("/^(.){1,255}$/", $target)){
                $_SESSION["target"] = "le public cible doit faire au maximum 255 caractères";
                $valid = false;
            }
            if($_FILES['files']["error"] === 0){
                if($file_type == "image/png" || $file_type == "image/jpeg"){
                    $destination = "upload/images/" . date("YmdHis"). $_FILES["files"]["name"];
                    $source = $_FILES["files"]["tmp_name"];
                }else{
                    $_SESSION["image"] = var_dump($_FILES['files']); 
                    $valid = false;
                }
                if($file_size > 500000){
                    $_SESSION["image2"] = "l'image ne doit pas dépasser 500ko  L'image doit être au format png ou jpeg ";
                    $valid = false;
                }
            }
            #redimensionner image 
            
            function load_image($name, $type){
                if( $type == "image/png"){
                    $image = imagecreatefrompng($name);
                }

                if( $type == "image/jpeg"){
                    $image = imagecreatefromjpeg($name);
                }

                return $image;
            }

            function scale_image($scale, $image, $width, $height, $tmp_name){
                $new_width = $width * $scale;
                $new_height = $height * $scale;
                return resize_image($new_width, $new_height, $image, $width, $height, $tmp_name);
            }

            function resize_image($new_width, $new_height, $image, $width, $height, $tmp_name){
                $new_image = imagecreatetruecolor($new_width, $new_height);
                imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                return imagejpeg($new_image, $tmp_name);
            }

            list($width, $height, $type) = getimagesize($tmp_name);
            $old_image = load_image($tmp_name, $file_type);

            if($height > 100){
                $scale1 = $height/100;
            }

            if($width > 100){
                $scale2 = $width/100;
            }

            if($scale1 > $scale2){
                $scale = $scale1;
            }else{
                $scale = $scale2;
            }
            
            $image_scaled = scale_image($scale, $old_image, $width, $height, $tmp_name);

            

            if($valid){
                move_uploaded_file($source, $destination);
                $ideeRepository->addIdea($title,$description,$target,$destination,$category,$priority,$_SESSION["id"]);

            }
            //Efface les variables contenant le mot de passe
            $_POST["password"] = null;
            $password = null;
            
        }
        
        $view = file_get_contents('view/page/add.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
    
    /**
     * Récupère la page de login
     * 
     * @return $content : la page de login
     */
    private function loginAction(){
        $view = file_get_contents('view/page/login.php');

        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
    
        /**
     * Récupère la page de login
     * 
     * @return $content : la page de login
     */
    private function connectAction(){
        $ideeRepository = new IdeeRepository();
        //vide les placeholders
        $_SESSION["firstNameForm"] = "";
        $_SESSION["userNameForm"] = "";
        $_SESSION["mailForm"] = "";
        $_SESSION["userExist"] = "";

        //Ajoute à la base de données le login et le mot de passe de l'utilisateur
        if(!empty($_POST)){
            $valid = true;
            //controle mail
            $mail = $_POST["mail"];
            if(!isset($mail) || empty($mail) || !preg_match("/^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$/", $mail)){
                $_SESSION["mailForm"] = "le mail n'est pas valide";
                $valid = false;
            }

            //
            if($valid){
                $check = $ideeRepository->login($_POST["mail"]);
                if(!password_verify($_POST["password"], $check[0]["acc_password"])){
                    $view = file_get_contents('view/page/login.php');
                
                    ob_start();
                    eval('?>' . $view);
                    $content = ob_get_clean();
            
                    return $content;
                }else{
                    $user = $ideeRepository->login($_POST["mail"]);
                    $_SESSION["login"] = $user[0]["acc_firstname"]." ".$user[0]["acc_name"];
                    $_SESSION["id"] = $user[0]["acc_id"];
                    $_SESSION["admin"] = $user[0]["acc_admin"];
                    $_SESSION["sortState"] = "%";
                    $_SESSION["sortCategory"] = "%";
                    if($user[0]['acc_admin'] == 1)
                    {
                        $_SESSION['isAdmin'] = true;
                    }
                    
                }
            }
            else{
                $view = file_get_contents('view/page/login.php');
        
                ob_start();
                eval('?>' . $view);
                $content = ob_get_clean();

                return $content;
            }

            //Efface les variables contenant le mot de passe
            $_POST["password"] = null;
            $password = null;
            
        }
    }

    /**
     * Récupère la page d'enregistrement
     * 
     * @return $content : la page d'enregistrement
     */
    private function signUpAction(){
        if(empty($_SESSION["firstNameForm"]))
        {
            $_SESSION["firstNameForm"] = "";
        }
        if(empty($_SESSION["userNameForm"]))
        {
            $_SESSION["userNameForm"] = "";
        }
        if(empty($_SESSION["mailForm"]))
        {
            $_SESSION["mailForm"] = "";
        }
        
        
        $view = file_get_contents('view/page/signup.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
    }
    /**
     * 
     * Déconnecte l'utilissateur et retourne a la page l'acceuil
     */
    private function disconnectAction(){
        $_SESSION["login"] = null;
        $_SESSION["admin"] = null;
        $_SESSION["sortState"] = null;
        $_SESSION["sortCategory"] = null;
        $_SESSION['isAdmin'] = null;

        header("Location: ./");
    }
    
    /**
     * applique la recherche et l'affiche dans la liste
     *
     * @return void
     */
    private function searchAction(){
        $ideeRepository = new IdeeRepository();
        $states = $ideeRepository->getAllStates();
        if(!empty($_POST["search"])||isset($_POST["search"]))
        {
            $_SESSION["search"] = $_POST["search"];
        }
        $idees = $ideeRepository->searchIdea($_SESSION["search"]);
        $categories = $ideeRepository->getAllCategories();
        $likedElements = $ideeRepository->getLikedElement($_SESSION["id"]);
        
        $string = $likedElements[0]["acc_liked"];

        $elements = explode(',', $string);

        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/list.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);
        // ob_get_clean permet de reprendre la lecture qui avait été stoppée (dans le but d'afficher la vue)
        $content = ob_get_clean();

        return $content;
    }
    

    private function sortAction(){
        if($_POST["state"] == "default")
        {
            $_SESSION['sortState'] = "%";
        }
        if($_POST["category"] == "default")
        {
            $_SESSION['sortCategory'] = "%";
        }
        if($_POST["state"] != "default")
        {
            $_SESSION['sortState'] = $_POST["state"];            
        }
        if($_POST["category"] != "default")
        {
            $_SESSION['sortCategory'] = $_POST["category"];          
        }   
        header('Location:?controller=&action=list');
    }

    private function addUserAction(){
        $ideeRepository = new IdeeRepository();
        //vide les placeholders
        $_SESSION["firstNameForm"] = "";
        $_SESSION["userNameForm"] = "";
        $_SESSION["mailForm"] = "";
        $_SESSION["userExist"] = "";

        //Ajoute à la base de données le login et le mot de passe de l'utilisateur
        if(!empty($_POST)){
            $valid = true;
            //controle mot de passe
            $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
            if(strlen($_POST["password"]) < 8){
                $_SESSION["passwordLenght"];
            }
            //controle prénom
            $firstName = $_POST["firstName"];
            if(!isset($firstName) || empty($firstName) || !preg_match("/^[A-Z][A-zÀ-ú' -]*$/", $firstName)){
                $_SESSION["firstNameForm"] = "le prénom ne doit contenir que des lettres et commencer par une majuscule";
                $valid = false;
            }
            //controle nom
            $userName = $_POST["userName"];
            if(!isset($userName) || empty($userName) || !preg_match("/^[A-Z][A-zÀ-ú' -]*$/", $userName)){
                $_SESSION["userNameForm"] = "le nom ne doit contenir que des lettres";
                $valid = false;
            }
            //controle mail
            $mail = $_POST["mail"];
            if(!isset($mail) || empty($mail) || !preg_match("/^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$/", $mail)){
                $_SESSION["mailForm"] = "le mail n'est pas valide";
                $valid = false;
            }
            
            $check = $ideeRepository->getOneUser($mail);

            //controle utilisateur déjà existant
            if(!empty($check[0]["acc_id"])){
                $_SESSION["mailForm"] = "cette adresse mail est déjà utilisée";
                $valid = false;
            }
            //
            if($valid){
                $ideeRepository->createUser($firstName, $userName, $mail, $password);
                //Connecte directement l'utilisateur après la création de son compte
                $user = $ideeRepository->login($mail);
                $_SESSION["login"] = $user[0]["acc_firstname"]." ".$user[0]["acc_name"];
                $_SESSION["id"] = $user[0]["acc_id"];
                $_SESSION["admin"] = $user[0]["acc_admin"];
                $_SESSION["sortState"] = "%";
                $_SESSION["sortCategory"] = "%";
                
            }else{
                $view = file_get_contents('view/page/signup.php');
        
                ob_start();
                eval('?>' . $view);
                $content = ob_get_clean();

                return $content;
            }

            //Efface les variables contenant le mot de passe
            $_POST["password"] = null;
            $password = null;
            
        }
    }

    private function getLikeAction()
    {
        $valid = true;

        $ideeRepository = new IdeeRepository();

        $likedElements = $ideeRepository->getLikedElement($_SESSION["id"]);

        $string = $likedElements[0]["acc_liked"];

        $elements = explode(',', $string);

        foreach($elements as $element)
        {
            if($valid)
            {
                if($element == $_POST["like"])
                {
                    $valid = false;
                }
                else
                {
                    $valid = true;
                }
            }
            
        }

        if($valid)
        {
            $ideeRepository->getLike($_POST["like"]);

            $string = $string.','.$_POST["like"];

            $ideeRepository->updateLikedElement($_SESSION["id"], $string);
        }
        else{
            $ideeRepository->delLike($_POST["like"]);
            if(($key = array_search($_POST["like"], $elements)) !== false) {
                unset($elements[$key]);
            }
            
            // Recréez la liste sans le nombre choisi
            $listeSansNombre = implode(",", $elements);

            $ideeRepository->updateLikedElement($_SESSION["id"], $listeSansNombre);
        }

        header('Location:'.$_SERVER['HTTP_REFERER']);
    }

    private function personalAction()
    {
        $ideeRepository = new IdeeRepository();
        $states = $ideeRepository->getAllStates();
        $categories = $ideeRepository->getAllCategories();
        $likedElements = $ideeRepository->getLikedElement($_SESSION["id"]);
        
        $string = $likedElements[0]["acc_liked"];

        $elements = explode(',', $string);

        // Instancie le modèle et va chercher les informations
        $idees = $ideeRepository->getMyIdea($_SESSION["sortCategory"], $_SESSION["sortState"], $_SESSION["id"]);

        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/list.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);
        // ob_get_clean permet de reprendre la lecture qui avait été stoppée (dans le but d'afficher la vue)
        $content = ob_get_clean();

        return $content;
    }

    private function eraseAction()
    {
        $ideeRepository = new IdeeRepository();
        $states = $ideeRepository->getAllStates();
        $categories = $ideeRepository->getAllCategories();
        $likedElements = $ideeRepository->getLikedElement($_SESSION["id"]);
        $ideeRepository->deleteIdea($_POST["erase"]);
        
        $string = $likedElements[0]["acc_liked"];

        $elements = explode(',', $string);

        // Instancie le modèle et va chercher les informations
        $idees = $ideeRepository->getMyIdea($_SESSION["sortCategory"], $_SESSION["sortState"], $_SESSION["id"]);

        // Charge le fichier pour la vue
        $view = file_get_contents('view/page/list.php');


        // Pour que la vue puisse afficher les bonnes données, il est obligatoire que les variables de la vue puisse contenir les valeurs des données
        // ob_start est une méthode qui stoppe provisoirement le transfert des données (donc aucune donnée n'est envoyée).
        ob_start();
        // eval permet de prendre le fichier de vue et de le parcourir dans le but de remplacer les variables PHP par leur valeur (provenant du model)
        eval('?>' . $view);
        // ob_get_clean permet de reprendre la lecture qui avait été stoppée (dans le but d'afficher la vue)
        $content = ob_get_clean();

        return $content;
    }

    private function editAction()
    {
        $ideeRepository = new IdeeRepository();
        $categories = $ideeRepository->getAllCategories();
        $priorities = $ideeRepository->getAllPriorities();
        $states = $ideeRepository->getAllStates();
        $idea = $ideeRepository->editIdea($_GET["id"]);
        $_SESSION["title"] = NULL;
        $_SESSION["category"] = NULL;
        $_SESSION["description"] = NULL;
        $_SESSION["target"] = NULL;
        $_SESSION["priority"] = NULL;
        $_SESSION["image"] = NULL;
        $_SESSION["image2"] = NULL;
        unset($_POST["edit"]);
        if($_POST){

            $tmp_name = $_FILES['files']['tmp_name'];
            $file_size = $_FILES['files']['size'];
            $file_type = $_FILES['files']['type'];

            
            $valid = true;
            //controle titre
            $title = $_POST["title"];
            if(!isset($title) || empty($title) || !preg_match("/^(.){1,255}$/", $title)){
                $_SESSION["title"] = "le titre doit faire au maximum 255 caractères";
                $valid = false;
            }
            $category = $_POST["category"];
            if(!isset($category) || empty($category)){
                $valid = false;
            }
            $validCategory = false;
            foreach($categories as $cat)
            {
                if($_POST["category"] == $cat["cat_id"]){
                    $validCategory = true;
                }
            }
            if($validCategory != true){
                $valid = false;
                $_SESSION["category"] = "choisisez une catégories existantes";
            }
            $validPriority = false;
            foreach($priorities as $priority)
            {
                if($_POST["priority"] == $priority["pri_id"]){
                    $validPriority = true;
                }
            }
            if($validPriority != true){
                $valid = false;
                $_SESSION["priority"] = "choisisez une priorités existantes";
            }
            $description = $_POST["description"];
            if(!isset($description) || empty($description) || !preg_match("/^(.){1,1000}$/", $description)){
                $_SESSION["description"] = "la description doit faire au maximum 1000 caractères";
                $valid = false;
            }
            $target = $_POST["cible"];
            if(!isset($target) || empty($target) || !preg_match("/^(.){1,255}$/", $target)){
                $_SESSION["target"] = "le public cible doit faire au maximum 255 caractères";
                $valid = false;
            }
            if($_FILES['files']["error"] = 0){
                if($file_type == "image/png" || $file_type == "image/jpeg"){
                }else{
                    $_SESSION["image"] = var_dump($_FILES['files']); 
                    $valid = false;
                }
                if($file_size > 500000){
                    $_SESSION["image2"] = "l'image ne doit pas dépasser 500ko  L'image doit être au format png ou jpeg ";
                    $valid = false;
                }
            }
            #redimensionner image 

            unset($_FILES);



            if($valid){
                $ideeRepository->changeIdea($_GET["id"], $title, $description, $target, $tmp_name, $category, $priority, $states, $_SESSION["id"]);
            }
            //Efface les variables contenant le mot de passe
            $_POST["password"] = null;
            $password = null;
            header("Location:?controller=Idee&action=list");

        }

        $view = file_get_contents('view/page/edit.php');
        
        ob_start();
        eval('?>' . $view);
        $content = ob_get_clean();

        return $content;
        
    }
}
