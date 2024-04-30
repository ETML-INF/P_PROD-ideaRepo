<?php
/*
 * Auteurs: Maël Gétain, Theo Orlando
 * Date: 17.01.2024
 * Description: Recueil des méthodes permettant de charger les données pour les idées
 * Copyright (c) 2024 ETML
 */

include_once "./data/Database.php";

class IdeeRepository
{
    /**
     * créée un utilisateur
     */
    public function createUser($firstname, $username, $mail, $userpassword)
    {
        $database = new Database();
        $database->createUser($firstname, $username, $mail, $userpassword);
        $database->closeConnexion();
    }

    /**
     * permet de se connecter
     * 
     */
    public function login($mail)
    {
        $database = new Database();
        $req = $database->login($mail);
        $user = $req->fetchAll();
        $database->closeConnexion();
        return $user;
        $database->clearData($req);
    }

    /**
     * permet d'obtenir des idées en fonction d'un filtre (pour toutes les avoir il faut mettre *)
     */
    public function getIdea($category, $state)
    {
        $database = new Database();
        $req = $database->getIdea($category, $state);
        $ideas = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $ideas;
    }

    /**
     * permet de savoir si un utilisateur avec la même adresse mail existe et aussi permet de se connecter
     * 
     */
    public function getOneUser($mail)
    {
        $database = new Database();
        $req = $database->getOneUser($mail);
        $user = $database->createData($req);
        $database->closeConnexion();
        return $user;
    }

    /**
     * permet de rechercher une idée via la barre de recherche
     */
    public function searchIdea($word)
    {
        $database = new Database();
        $req = $database->searchIdea($word);
        $ideas = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $ideas;
    }

    public function addIdea($title, $description, $target, $image, $category, $priority, $userId)
    {
        $database = new Database();
        $database->addIdea($title, $description, $target, $image, $category, $priority, $userId);
        $database->closeConnexion();
    }

    public function getAllCategories()
    {
        $database = new Database();
        $req = $database->getAllCategories();
        $categories = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $categories;
    }

    public function getAllStates()
    {
        $database = new Database();
        $req = $database->getAllStates();
        $states = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $states;
    }

    public function getAllPriorities()
    {
        $database = new Database();
        $req = $database->getAllPriorities();
        $priorities = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $priorities;
    }

    /**
     * permet d'obtenir des idées en fonction d'un filtre (pour toutes les avoir il faut mettre *)
     */
    public function getIdeaSorted($state)
    {
        $database = new Database();
        $req = $database->getIdeaSorted($state);
        $ideas = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $ideas;
    }

    public function getLike($id)
    {
        $database = new Database();
        $database->getLike($id);
        $database->closeConnexion();
    }

    public function getLikedElement($id)
    {
        $database = new Database();
        $req = $database->getLikedElement($id);
        $likedElements = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $likedElements;
    }

    public function delLike($id)
    {
        $database = new Database();
        $database->delLike($id);
        $database->closeConnexion();
    }

    public function updateLikedElement($id, $string)
    {
        $database = new Database();
        $database->updateLikedElement($id, $string);
        $database->closeConnexion();
    }

    public function getMyIdea($category, $state, $id)
    {
        $database = new Database();
        $req = $database->getMyIdea($category, $state, $id);
        $ideas = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $ideas;
    }

    public function deleteIdea($id)
    {
        $database = new Database();
        $database->deleteIdea($id);
        $database->closeConnexion();
    }

    public function editIdea($id)
    {
        $database = new Database();
        $req = $database->getOneIdea($id);
        $idea = $database->createData($req);
        $database->clearData($req);
        $database->closeConnexion();
        return $idea;
    }

    public function changeIdea($idid, $title, $description, $target, $image, $category, $priority, $state, $userId)
    {
        $database = new Database();
        $database->changeIdea($idid, $title, $description, $target, $image, $category, $priority, $state, $userId);
        $database->closeConnexion();
    }
}
