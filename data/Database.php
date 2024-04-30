<?php
    class Database {

        //connecteur PDO
        public $connector;

        /**
         * se connecte à la BDD
         *
         * @return void
         */
        public function __construct() {
            $mdp = "Pr0ut2M@mout";
            $user = "desantos";
            $dbName= "repo";
            $port = "6033";
            $this->connector = new PDO('mysql:host=localhost:' . $port . ';dbname=' .$dbName . ';charset=utf8', $user, $mdp);
        }

        /**
         * créer un tableau associatif de la requête
         *
         * @param [type] $req
         * @return void
         */
        public function createData($req)
        {
            $action = $req->fetchALL(PDO::FETCH_ASSOC);
            return $action;
        }

        /**
         * vide la requête
         *
         * @param [type] $req
         * @return void
         */
        public function clearData($req)
        {
            $req->closeCursor();
        }

        /**
         * ferme la connexion PDO
         *
         * @return void
         */
        public function closeConnexion()
        {
            $this->connector = null;
        }

        /**
         * récupère toutes les idées pour une certaine catégorie. Va donc être utiliés dans toutes les sections mais avec un paramètres différent. 
         * 
         * @param [int] $id
         * @return void
         */
        public function getIdea($category, $state)
        {
            $req = $this->connector->prepare("SELECT * FROM t_idea INNER JOIN t_category ON t_idea.ide_category_fk = t_category.cat_id WHERE ide_category_fk LIKE :category AND ide_state_fk LIKE :sta ORDER BY ide_like DESC");
            $req->bindValue(':category',$category ,PDO::PARAM_STR);
            $req->bindValue(':sta',$state ,PDO::PARAM_STR);
            $req->execute();
            return $req;
        }

        /**
         * créé un nouvel utilisateur
         * 
         * @param [string] $firstname
         * @param [string] $username
         * @param [string] $mail
         * @param [string] $userpassword
         * @return void
         */
        public function createUser($firstname, $username, $mail, $userpassword)
        {
            
            $query = "INSERT INTO t_account (acc_id, acc_firstname, acc_name, acc_mail, acc_password, acc_liked, acc_admin) VALUES (NULL, :firstname, :username, :mail, :userpassword, 0, 0)";
            
            /*
            var_dump($query);

            var_dump($firstname);
            var_dump($username);
            var_dump($mail);
            var_dump($userpassword);
            */
            $req = $this->connector->prepare($query);
            $req->bindValue(':firstname',$firstname,PDO::PARAM_STR);
            $req->bindValue(':username',$username,PDO::PARAM_STR);
            $req->bindValue(':mail',$mail,PDO::PARAM_STR);
            $req->bindValue(':userpassword',$userpassword,PDO::PARAM_STR);

            $req->execute();
        }

        /**
         * permet de se connecter
         * 
         * @param [string] $mail
         * @param [string] $userpassword
         */
        public function login($mail)
        {
            $req = $this->connector->prepare("SELECT acc_id, acc_password, acc_firstname, acc_name, acc_admin FROM t_account WHERE `acc_mail` = :mail");
            $req->bindValue(':mail', $mail, PDO::PARAM_STR);
            $req->execute();
            return $req;
        }

        public function getOneUser($mail)
        {
            $req = $this->connector->prepare("SELECT acc_id FROM t_account WHERE `acc_mail` = :mail");
            $req->bindValue(':mail', $mail, PDO::PARAM_STR);
            $req->execute();
            return $req;
        }

        public function searchIdea($word)
        {
            $req = $this->connector->prepare("SELECT * FROM t_idea WHERE ide_title LIKE CONCAT('%',:word,'%')");
            $req->bindValue(':word', $word, PDO::PARAM_STR);
            $req->execute();
            return $req;
        }

        public function addIdea($title, $description, $target, $image, $category, $priority, $userId)
        {
            $req = $this->connector->prepare("INSERT INTO t_idea (ide_id, ide_title, ide_description, ide_target, ide_image, ide_category_fk, ide_priority, ide_account_fk) VALUES (NULL, :title, :ideDescription, :ideTarget, LOAD_FILE(:ideImage), :category, :priority, :creator)");
            $req->bindValue(':title', $title, PDO::PARAM_STR);
            $req->bindValue(':ideDescription', $description, PDO::PARAM_STR);
            $req->bindValue(':ideTarget', $target, PDO::PARAM_STR);
            $req->bindValue(':ideImage', $image, PDO::PARAM_STR);
            $req->bindValue(':category', $category, PDO::PARAM_INT);
            $req->bindValue(':priority', $priority, PDO::PARAM_INT);
            $req->bindValue(':creator', $userId, PDO::PARAM_INT);
            
            $req->execute();
        }

        public function getAllCategories()
        {
            $req = $this->connector->prepare("SELECT * FROM t_category");
            $req->execute();
            return $req;
        }

        public function getAllPriorities()
        {
            $req = $this->connector->prepare("SELECT * FROM t_priority");
            $req->execute();
            return $req;
        }

        public function getAllStates()
        {
            $req = $this->connector->prepare("SELECT * FROM t_state");
            $req->execute();
            return $req;
        }

        /**
         * récupère toutes les idées pour une certaine catégorie. Va donc être utiliés dans toutes les sections mais avec un paramètres différent. 
         * 
         * @param [int] $id
         * @return void
         */
        public function getIdeaSorted($state)
        {
            $req = $this->connector->prepare("SELECT * FROM t_idea INNER JOIN t_state ON t_idea.ide_state_fk = t_state.sta_id WHERE ide_state_fk = :id OR '*' = :id");
            $req->bindValue(':id',$state ,PDO::PARAM_STR);
            $req->execute();
            return $req;
        }

        public function getLike($id)
        {
            $req = $this->connector->prepare("UPDATE t_idea SET ide_like = ide_like+1 WHERE ide_id = :id");
            $req->bindValue(':id',$id,PDO::PARAM_INT);
            $req->execute();
        }

        public function getLikedElement($id)
        {
            $req = $this->connector->prepare("SELECT acc_liked FROM t_account WHERE acc_id = :id");
            $req->bindValue(':id',$id,PDO::PARAM_INT);
            $req->execute();
            return $req;
        }

        public function delLike($id)
        {
            $req = $this->connector->prepare("UPDATE t_idea SET ide_like = ide_like-1 WHERE ide_id = :id");
            $req->bindValue(':id',$id,PDO::PARAM_INT);
            $req->execute();
            return $req;
        }

        public function updateLikedElement($id, $string)
        {
            $req = $this->connector->prepare("UPDATE t_account SET acc_liked = :string WHERE acc_id = :id");
            $req->bindValue(':id',$id,PDO::PARAM_INT);
            $req->bindValue(':string',$string,PDO::PARAM_STR);
            $req->execute();
            return $req;
        }

        public function getMyIdea($category, $state, $id)
        {
            $req = $this->connector->prepare("SELECT * FROM t_idea INNER JOIN t_category ON t_idea.ide_category_fk = t_category.cat_id WHERE ide_category_fk LIKE :category AND ide_state_fk LIKE :sta AND ide_account_fk = :id ORDER BY ide_like DESC");
            $req->bindValue(':category',$category ,PDO::PARAM_STR);
            $req->bindValue(':sta',$state ,PDO::PARAM_STR);
            $req->bindValue(':id',$id ,PDO::PARAM_INT);
            $req->execute();
            return $req;
        }

        public function deleteIdea($id)
        {
            $req = $this->connector->prepare("DELETE FROM t_idea WHERE ide_id = :id");
            $req->bindValue('id', $id, PDO::PARAM_INT);
            $req->execute();
        }

        public function getOneIdea($id)
        {
            $req = $this->connector->prepare("SELECT * FROM t_idea INNER JOIN t_category INNER JOIN t_priority WHERE ide_id = :id");
            $req->bindValue('id', $id, PDO::PARAM_INT);
            $req->execute();
            return $req;
        }

        public function changeIdea($idid, $title, $description, $target, $image, $category, $priority, $state, $userId)
        {
            $req = $this->connector->prepare("UPDATE t_idea SET (ide_id, ide_title, ide_description, ide_target, ide_image, ide_category_fk, ide_priority, ide_status, ide_account_fk) VALUES (NULL, :title, :ideDescription, :ideTarget, LOAD_FILE(:ideImage), :category, :priority, :sta, :creator) WHERE ide_id=:idid");
            $req->bindValue(':title', $title, PDO::PARAM_STR);
            $req->bindValue(':ideDescription', $description, PDO::PARAM_STR);
            $req->bindValue(':ideTarget', $target, PDO::PARAM_STR);
            $req->bindValue(':ideImage', $image, PDO::PARAM_STR);
            $req->bindValue(':category', $category, PDO::PARAM_INT);
            $req->bindValue(':priority', $priority, PDO::PARAM_INT);
            $req->bindValue(':sta', $state, PDO::PARAM_INT);
            $req->bindValue(':creator', $userId, PDO::PARAM_INT);
            $req->bindValue(':idid', $userId, PDO::PARAM_INT);
            
            $req->execute();
        }
    }
