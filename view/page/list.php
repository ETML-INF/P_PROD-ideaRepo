<?php
/*
 * Auteurs: Maël Gétain, Theo Orlando
 * Date: 04.12.2023
 * Description: liste les idées en fonction de leur état (par défuat toutes les idées)
 * Copyright (c) 2022 ETML
 */
$valid = false;
if(empty($_SESSION["login"])){
  header("Location:?Controller=idee&action=login");
}
?>
<script>
  document.addEventListener("DOMContentLoaded", function(event) { 
      var scrollpos = localStorage.getItem('scrollpos');
      if (scrollpos) window.scrollTo(0, scrollpos);
  });

  window.onbeforeunload = function(e) {
      localStorage.setItem('scrollpos', window.scrollY);
  };
</script>
<div class="d-flex"><form action="?controller=&action=sort" method="POST" class="me-lg-3" role="search">
  <div class="d-flex">
    <div class="d-flex">
      <select class="form-control" id="category" name="state" required>
            <option selected value="default">Etat de l'idée</option>
            <?php
            //Liste des états possibles
                foreach($states as $state){
                  if($state["sta_id"] == $_SESSION["sortState"])
                  {
            ?>
            <option selected value="<?=$state["sta_id"]?>"><?=$state["sta_name"]?></option>
            <?php
                  }
                  else
                  {
            ?>
            <option value="<?=$state["sta_id"]?>"><?=$state["sta_name"]?></option>
            <?php
                  }
                }            
            ?>
        </select>
    </div>
    <div class="d-flex">
      <select class="form-control" id="category" name="category" required>
            <option selected value="default">Catégorie de l'idée</option>
            <?php
            //Liste des catégories possibles
                foreach($categories as $category){
                  if($category["cat_id"] == $_SESSION["sortCategory"])
                  {
            ?>
            <option selected value="<?=$category["cat_id"]?>"><?=$category["cat_name"]?></option>
            <?php
                  }
                  else
                  {
            ?>
            <option value="<?=$category["cat_id"]?>"><?=$category["cat_name"]?></option>
            <?php
                  }
                }            
            ?>
        </select>
        <button style="background-color:#253F2E;" type="submit" class="btn btn-primary">Rechercher</button>
    </div>
  </div>
</form>
</div>
<div class="">
  <?php
  $x = 1;
    foreach($idees as $idee)
    {
      if($x == 1){
        echo "<div class='card-group'>";
      }
  ?>
  <div class="card m-3" style="max-width: 35rem;">
    <img src=<?php echo "data:image/jpeg;base64,".base64_encode( $idee['ide_image'] );?> class="card-img-top" alt="image représentant le projet">
    <div class="card-body ">
      <h5 class="card-title"><?= $idee["ide_title"]?></h5>
      <p class="card-text">Description: <?= $idee["ide_description"]?></p>
      <p class="card-text">Public cible: <?= $idee["ide_target"]?></p>
      <?php 
        foreach($categories as $category)
        {
          if($category["cat_id"] == $idee["ide_category_fk"]){
            echo "<p class='card-text'>catégorie: ".$category["cat_name"];
          }
        }
      ?>
      <?php 
        foreach($states as $state)
        {
          if($state["sta_id"] == $idee["ide_state_fk"]){
            echo "<p class='card-text'>status: ".$state["sta_name"]; 
          }
        }
      ?>
      <div class="d-flex justify-content-between">
      <p class='card-text'>Action: </p>
        <?php
        if($idee['ide_account_fk'] == $_SESSION['id'] || $_SESSION['isAdmin'])
        {
        ?>
        <div>
          <form action="?controller=&action=edit&id=<?=$idee['ide_id']?>" method="POST">
            <button class="btn btn-primary" style="background-color:#253F2E;" value="<?=$idee['ide_id']?>" name="edit" ><img src="ressources/image/edit.png" alt="logo edit"></button>
          </form>
        </div>
        <div>
          <form action="?controller=&action=erase" method="POST">
            <button class="btn btn-primary" style="background-color:#253F2E;" value="<?=$idee['ide_id']?>" name="erase" ><img src="ressources/image/trash.png" alt="logo bin"></button>
          </form>
        </div>
      <?php
        }
      ?>
      <div>
      <form action="?controller=&action=getLike" method="POST">
        <?php
          foreach($elements as $element)
          {
            if(!$valid)
            {
              if($element == $idee['ide_id'])
              {
                  $valid = true;
              }
              else
              {
                  $valid = false;
              }
            }
          }
          if($valid)
          {
        ?>
        <button class="btn btn-primary text-danger" style="background-color:#253F2E;" type="submit" value="<?=$idee['ide_id']?>" name="like">♥-<?=$idee["ide_like"]?></button>
        <?php
            $valid = false;
          }
          else
          {
        ?>
        <button class="btn btn-primary" style="background-color:#253F2E;" type="submit" value="<?=$idee['ide_id']?>" name="like">♥-<?=$idee["ide_like"]?></button>
        <?php
            $valid = false;
          }
        ?>
      </form>
      </div>
      </div>
    </div>
  </div>
  <?php

    if( $x % 3 == 0){
      echo "</div>";
    }

    if( $x % 3 == 0){
      echo "<div class='card-group'>";
    }

    $x++;
    https://getbootstrap.com/docs/4.0/components/card/


    }
  ?>
  </div>
</div>