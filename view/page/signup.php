<?php
/*
 * Auteurs: Maël Gétain, Eliott Deriaz, Néo Masson, Theo Orlando
 * Date: 29.11.2022
 * Description: page d'inscription de l'utilisateur
 * Copyright (c) 2022 ETML
 */
$_SESSION["verification"] = 0;
if(!empty($_SESSION["userExist"])){?>

  <div class="alert">
  <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
  <?$_SESSION["userExist"]?>
  </div>

<?php
}
?>
<!--Formulaire d'inscription-->
<form action="?controller=Idee&action=addUser" method="POST">
  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card text-white" style="border-radius: 1rem; background-color: #BACEC1;">
            <div class="card-body p-5 text-center">
              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">S'enregistrer</h2>
                <p class="text-black-50 mb-5">S'il vous plaît entrez les informations de votre nouveau commpte</p>

                <div class="form-outline form-white mb-4">
                <label class="text-black-50 form-label" for="firstName">Prénom</label>
                  <input type="text" id="firstName" class="form-control form-control-lg" name="firstName" placeholder="<?=$_SESSION["firstNameForm"]?>"/>
                </div>
                <div class="form-outline form-white mb-4">
                <label class="text-black-50 form-label" for="userName">Nom</label>
                  <input type="text" id="userName" class="form-control form-control-lg" name="userName" placeholder="<?=$_SESSION["userNameForm"]?>"/>
                </div>
                <div class="form-outline form-white mb-4">
                <label class="text-black-50 form-label" for="mail">adresse mail</label>
                  <input type="text" id="mail" class="form-control form-control-lg" name="mail" placeholder="<?=$_SESSION["mailForm"]?>"/>
                </div>
                <div class="form-outline form-white mb-4">
                <label class="text-black-50 form-label" for="password">Mot de passe</label>
                  <input type="password" id="password" class="form-control form-control-lg" name="password" placeholder="min.8 caractères"/>
                </div>

                <button style="background-color:#1D3124;" class="btn btn-outline-light btn-lg px-5" type="submit">S'enregistrer</button>
              </div>
              <div>
                <p class="text-black-50 mb-0">Vous avez déjà un compte ? <a href="?controller=Idee&action=login" class="text-black-50 fw-bold">S'enregistrer</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</form>