<?php
/*
 * Auteurs: Maël Gétain, Eliott Deriaz, Néo Masson, Theo Orlando
 * Date: 22.11.2022
 * Description: page d'ajout de sportifs
 * Copyright (c) 2022 ETML
 */
$_SESSION["verification"] = 0;
//contrôle que seul les admins aient accès à la page et retourne a l'acceuil avec une alerte si ça n'est pas le cas

if(empty($_SESSION["login"])){
    header("Location:?Controller=idee&action=login");
  }
?>
<br>
    

<?php if(!empty($_SESSION["title"])){echo '';}?>
<!--Formulaire d'ajout de sportif-->
<form action="?controller=Idee&action=edit&id=<?=$idea[0]['ide_id']?>" method="POST" class="w-50 mx-auto needs-validation" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="firstName" class="form-label">Titre</label>
        <input type="text" class="form-control w50" id="title" aria-describedby="emailHelp" name="title" autocomplete="off" value="<?=$idea[0]['ide_title']?>" placeholder="<?php if(!empty($_SESSION["title"])){echo $_SESSION['title'];}?>" required>
    </div>
    <div class="form-group">
        <br>
        <label for="category">Catégories:</label>
        <select class="form-control" id="category" name="category" required>
            <option selected value=""><?php if(!empty($_SESSION["category"])){echo $_SESSION["category"];}else{echo "Veuillez choisir une catégorie";} ?></option>
            <?php
            //Liste des choix de sports possibles
                foreach($categories as $category){
            ?>
            <option <?php if($idea[0]['ide_category_fk']==$category["cat_id"]){?>selected<?php } ?> value="<?=$category["cat_id"]?>"><?=$category["cat_name"]?></option>
            <?php
                }            
            ?>
        </select>
    </div>
    <div class="form-group">
        <br>
        <label for="priority">Priorités:</label>
        <select class="form-control" id="priority" name="priority" required>
            <option selected value=""><?php if(!empty($_SESSION["priority"])){echo $_SESSION["priority"];}else{echo "Veuillez choisir une priorité";} ?></option>
            <?php
            //Liste des choix de sports possibles
                foreach($priorities as $priority){
            ?>
            <option <?php if($idea[0]['ide_priority_fk']==$priority["pri_id"]){?>selected<?php } ?> value="<?=$priority["pri_id"]?>"><?=$priority["pri_name"]?></option>
            <?php
                }            
            ?>
        </select>
    </div>
    <div class="form-group">
        <br>
        <label for="state">Status:</label>
        <select class="form-control" id="state" name="state" required>
            <option selected value=""><?php if(!empty($_SESSION["state"])){echo $_SESSION["state"];}else{echo "Veuillez choisir un status";} ?></option>
            <?php
            //Liste des choix de sports possibles
                foreach($states as $state){
            ?>
            <option <?php if($idea[0]['ide_priority_fk']==$state["sta_id"]){?>selected<?php } ?> value="<?=$state["sta_id"]?>"><?=$state["sta_name"]?></option>
            <?php
                }            
            ?>
        </select>
    </div>
    <br>
    <div class="form-floating">
        <textarea class="form-control" placeholder="bonjour/<?php if(!empty($_SESSION["description"])){echo $_SESSION["description"];}?>;" id="description" style="height: 150px"  name="description" required><?=$idea[0]['ide_description']?></textarea>
        <label for="description">Description de l'idée de projet</label>
    </div>
    <br>
    <div class="form-floating">
        <textarea class="form-control" placeholder="<?php if(!empty($_SESSION["target"])){echo $_SESSION["target"];}?>" id="cible" style="height: 80px"  name="cible" required><?=$idea[0]['ide_target']?></textarea>
        <label for="cible">public cible du projet</label>
    </div>
    <div class="mb-4 d-flex justify-content-center m-5">
        <div class="btn btn-primary btn-rounded m-5" style="background-color:#253F2E;">
            <label class="form-label text-white m-1" for="customFile1">Choisir une image...</label>
            <input type="file" class="form-control d-none" id="customFile1" onchange="displaySelectedImage(event, 'selectedImage')" name="files" />
        </div>
        <img id="selectedImage" src="<?php echo "data:image/jpeg;base64,".base64_encode( $idea[0]['ide_image'] )?>" alt="image of the project" style="width:150px;" />
    </div>
    <?php ?>
    <div class="d-flex justify-content-center">
        <?php
            if($_SESSION["image"] != null){
                echo "<p>" . $_SESSION["image"] . "</p>";
                echo " " . "<p>" . $_SESSION["image2"] . "</p>";
            }
        ?>
    </div>
</div>
    <button style="background-color:#253F2E;" type="submit" class="btn btn-primary">Modifier</button>
</form>
<script>
    function displaySelectedImage(event, elementId) {
    const selectedImage = document.getElementById(elementId);
    const fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            selectedImage.src = e.target.result;
        };

        reader.readAsDataURL(fileInput.files[0]);
    }
}
</script>