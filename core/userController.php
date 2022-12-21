<?php
    session_start();
    // On analyse ce qu'il y a à faire
    $action = "empty";
    // si la clé "execute" est détectée dans $_POST (avec la balise input type hidden)
    if (isset($_POST["execute"])){
        // notre variable action est égale à la valeur de la clé "execute"
        $action = $_POST["execute"];
    }

    // on utilise un switch pour vérifier l'action
    switch ($action):
        // log-admin correspond à value="log-admin" dans l'input hidden du fichier admin/index.php
        case "log-admin":
            logAdmin();
            break;
        case "log-out":
            logOut();
            break;
        case "update":
            updateUser();
            break;
        endswitch;

    // les différentes fonctions de notre controller 

    function logAdmin(){
        // on a besoin de notre page connexion
        require("connexion.php");
        // vérification de l'email de l'admin qui est une valeur unique, préparation des données et formatage
        $login = trim(strtolower($_POST["login"]));
        // écriture SQL (Read du CRUD)
        $sql = "SELECT * FROM table_user WHERE mail = '$login'";
        // exécution de la requête
        $query = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
        // traitement des données
        // on vérifie que l'email existe avec la fonction mysqli_num_rows() qui compte le nombre de lignes retournées
        if(mysqli_num_rows($query) > 0){
            // on met sous forme de tableau associatif les données de l'admin récupéré
            $user = mysqli_fetch_assoc($query);

            // ensuite il faut vérifier si le mot de passe saisi est égal à l'encodage stocké en bdd avec la fonction password_verify() qui nous renvoie true ou false
            if(password_verify(trim($_POST["password"]), $user["password"])){
                // On vérifie le rôle dans la bdd (1 équivaut à un admin)
                if($user["role"] != 1){
                    // on envoie un message d'alerte
                    $_SESSION["message"] = "Vous n'êtes pas l'administrateur";
                    // Redirection vers la page d'accueil. 
                    header("Location: ../inc/index.php");
                    exit;
                }else{
                    // on créé plusieurs variables de session qui permettent un affichage personne et de sécuriser l'accès au back-office
                    $_SESSION["prenom"] = $user["prenom"] ;
                    $_SESSION["isLogged"] = true;
                    $_SESSION["role"] = $user["role"];
                    header('Location: ../admin/accueilAdmin.php');
                    exit;
                }
            }else{
                // Sinon erreur de mot de passe.
                $_SESSION["message"] = "Erreur de mot de passe !!!";
                header('Location: ../admin/index.php');
                exit;
            }
        }else{
            // Administrateur non trouvé. 
            $_SESSION["message"] = "Désolé, pas d'administrateur identifié";
            header('Location: http://localhost/admin/index.php');
            exit;
        }
    }
    function logOut(){
        // Pour déconnecter l'admin il faut supprimer les variables de session.
        // On détruit la session avec session_destroy()
        session_destroy();
        session_start();
        // message flash
        $_SESSION["message"] = "Vous êtes bien déconnecté.";
        // Redirection vers la page d'accueil du site
        header("Location: ../admin/index.php");
    }
    function updateUser(){
        // Mise à jour des informations de l'utilisateur.
        // Vérifier si les informations ont bien été envoyées.
        if(!isset($_POST["nom"], $_POST["prenom"], $_POST["mail"], $_POST["password"], $_POST["role"], $_POST["id_user"])){
            $_SESSION["message"] = "Informations manquantes dans le formauaire !";
            header("Location: ../admin/updateUser.php?id_user=" . $_POST["id_user"]);
            exit;
        }
        // Récupération des infos envoyées par le formulaire de updateUser.
        $nom = ucfirst(trim($_POST["nom"]));
        $prenom = ucfirst(trim($_POST["prenom"]));
        $mail = strtolower(trim($_POST["mail"]));
        $motdepasse = trim($_POST["password"]);
        $role = $_POST["role"];
        $id = $_POST["id_user"];
        
        // Validation des informations
        if(strlen($nom) < 1 || strlen($nom) > 255){
            $_SESSION["message"] = "Le nom doit avoir entre 1 et 255 caractères.";
            header("Location: ../admin/updateUser.php?id_user=" . $_POST["id_user"]);
            exit;
        }
        if(strlen($prenom) < 1 || strlen($prenom) > 255){
            $_SESSION["message"] = "Le prenom doit avoir entre 1 et 255 caractères.";
            header("Location: ../admin/updateUser.php?id_user=" . $_POST["id_user"]);
            exit;
        }
        if(strlen($mail) < 1 || strlen($mail) > 255 || !filter_var($mail, FILTER_VALIDATE_EMAIL)){
            $_SESSION["message"] = "L'adresse mail est invalide.";
            header("Location: ../admin/updateUser.php?id_user=". $_POST["id_user"]);
            exit;
        }
        if(strlen($motdepasse) < 1){
            $_SESSION["message"] = "Le mot de passe doit avoir au moins 1 caractère.";
            header("Location: ../admin/updateUser.php?id_user=" . $_POST["id_user"]);
            exit;
        }
        if($role != 1 && $role!=2){
            $_SESSION["message"] = "Le rôle est invalide.";
            header("Location: ../admin/updateUser.php?id_user=" . $_POST["id_user"]);
            exit;
        }
        $options = ['cost' => 12];
        $motdepasse = password_hash($motdepasse, PASSWORD_DEFAULT, $options);
        // Les données sont validées, il faut maintenant les envoyer dans la BDD.
        require("connexion.php");
        $sql = "UPDATE table_user
                SET `nom` = '$nom', `prenom` = '$prenom', `mail` = '$mail', `role` = $role, `password` = '$motdepasse'
                WHERE `id_user`= $id
                ";
        $query = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
        $_SESSION["message"] = "Mes données ont bien été mises à jour.";
        header("Location: ../admin/updateUser.php?id_user=" . $_POST["id_user"]);
        exit;
    }
    function deleteUser(){
        require("connexion.php");
        
    }
?>