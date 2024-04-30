<?php
/*
 * Auteurs: Maël Gétain, Theo Orlando
 * Date: 17.01.2024
 * Description: controlleur principal
 * Copyright (c) 2024 ETML
 */


abstract class Controller {

    /**
     * Méthode permettant d'appeler l'action 
     *
     * @return mixed
     */
    public function display() {

        $page = $_GET['action'] . "Display";

        $this->$page();
    }
}