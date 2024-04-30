<?php
/*
 * Auteurs: Maël Gétain, Theo Orlando
 * Date: 20.11.2023
 * Description: page de connexion de l'utilisateur
 * Copyright (c) 2023 ETML
 */
$_SESSION["verification"] = 0;
?>
<!--Formulaire de connexion-->
<form action="?controller=Athlete&action=connect" method="POST">
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-white" style="border-radius: 1rem; background-color: #BACEC1;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">

                <h2 class="fw-bold mb-2 text-uppercase">S'identifier</h2>
                <p class="text-black-50 mb-5">S'il vous plaît entrez votre adresse mail et votre mot de passe !</p>

                <div class="form-outline form-white mb-4">
                <label class="text-black-50 form-label" for="mail">adresse mail</label>
                  <input type="text" id="mail" class="form-control form-control-lg" name="mail"/>
                </div>

                <div class="form-outline form-white mb-4">
                <label class="text-black-50 form-label" for="password">Mot de passe</label>
               <input type="password" id="password" class="form-control form-control-lg" name="password"/>
                </div>

                <button style="background-color:#1D3124;" class="btn btn-outline-light btn-lg px-5" type="submit">S'identifier</button>
              </div>

              <div>
                <p class="text-black-50 mb-0">Vous n'avez pas encore de compte ? <a href="?controller=Athlete&action=signUp" class="text-black-50 fw-bold">S'enregistrer</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</form>