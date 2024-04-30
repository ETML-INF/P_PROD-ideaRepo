<?php
/*
 * Auteurs: Maël Gétain, Eliott Deriaz, Néo Masson, Theo Orlando
 * Date: 29.11.2022
 * Description: menu du site
 * Copyright (c) 2022 ETML
 */
?>
<body style="background-color:#F6F4E8;" class="d-flex flex-column min-vh-100 ">
<header class="p-3 text-white" style="background-color:#BACEC1;">
    <div class="container">
      <div class="d-flex align-items-center justify-content-center justify-content-lg-start">
      <a href="./" ><img src="ressources/image/logo1.png" alt="notre logo" class="img-fluid me-5"></a>
        <ul class="nav col-lg-auto mb-2 justify-content-center mb-md-0">
            <li class="nav-item">
                <button type="button" style="background-color:#253F2E; margin-right: 50px;" onclick="window.location.href = './'" class="btn btn-primary nav-item me-2">Accueil</button>
            </li>
            <?php if(!empty($_SESSION["login"])){?>
            <li class="nav-item">
                <button type="button" style="background-color:#253F2E;" onclick="window.location.href = '?controller=Idee&action=list'" class="btn btn-primary nav-item me-2">Toutes les idées</button>
            </li>
            <?php 
                }   
            ?>
            <li class="nav-item">
                <button type="button" style="background-color:#253F2E;" onclick="window.location.href = '?controller=Idee&action=about'" class="btn btn-primary nav-item me-2">À propos</button>
            </li>
            <?php if(!empty($_SESSION["login"])){?>
            <li class="nav-item">
                <button type="button" style="background-color:#253F2E;" onclick="window.location.href = '?controller=Idee&action=add'" class="btn btn-primary nav-item me-2">+</button>
            </li>
            <?php 
                }   
            ?>
            <li class="nav-item">
                <form action="?controller=&action=search" method="POST" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Rechercher..." aria-label="Recipient's username" aria-describedby="button-addon2" name="search" autocomplete="off">
                        <input style="background-color:#253F2E; color:white;" class="btn btn-outline-secondary"type="submit" value="Rechercher">
                    </div>
                </form>
            </li>
            <?php if(empty($_SESSION["login"])){?>
            <li class="nav-item">
                <div class="text-end">
                    <button type="button" style="background-color:#253F2E;" onclick="window.location.href = '?controller=Idee&action=login'" class="btn btn-primary nav-item me-2">Connexion</button>
                </div>
            </li>
            <?php 
            }
            else{
            ?>
            <li class="nav-item">
                <div class="d-flex text-end text-dark">
                    <label class="mx-2"><?=$_SESSION["login"]?></label>
                    <button style="background-color:#253F2E;" type="button" onclick="window.location.href = '?controller=Idee&action=disconnect'" class="btn btn-primary ms-4">Déconnexion</button>
                    <button style="background-color:#253F2E;" type="button" onclick="window.location.href = '?controller=Idee&action=personal'" class="btn btn-primary ms-4"><img src="ressources/image/user.png" alt="logo user"></button>
                </div>
            </li>
            <?php }?>
        </ul>
        </div>
    </div>
</header>
