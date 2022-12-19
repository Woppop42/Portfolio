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
?>