<?php
// Il faut créer un user avec le rôle admin dans la BDD pour avoir un administrateur du back-office.
// Pour cela on crée un formulaire pour renseigner la BDD. 
// Au niveau du CRUD nous allons faire un Create avec l'instruction **SQL INSERT INTO**.
include("../inc/headFront.php");
include("../inc/headerFront.php");
?>
<main>
<div class="container">
    <div class="row text-center">
        <h3 class="text-center">Administrateur</h3>
        <div class="col-12">
            <form action="" method="post">
                <input type="text" name="nom" id="nom" placeholder="Votre nom">
                <input type="text" name="prenom" id="prenom" placeholder="Votre prénom">
                <input type="text" name="mail" id="mail" placeholder="Votre mail">
                <input type="password" name="password" id="password" placeholder="Votre mot de passe"> 
                <input type="checkbox" name="role_admin" id="role_admin">
                <label for="role_admin">Je suis un administrateur</label> <br>
                <button type="submit" name="soumettre" class="btn btn-warning fw-bold">LOG IN</button>
                
            </form>
        </div>
    </div>
</div>
<?php
// On récupère le fichier de connexion (connexion.php) correspondant aux paramètres de connexion de notre BDD.
require("../core/connexion.php");
// Une condition pour récupérer les données du formulaire.
if(isset($_POST["soumettre"])){
    $nom = addslashes(trim(ucfirst($_POST["nom"]))); //addslashes() permet de garder les caractères spéciaux tels que les apostrophes par exemple.trim() supprime les espaces avant et après et ucfirst() met une majuscule en début de mot. Les trois sont des fonctions natives. 
    $prenom = addslashes(trim(ucfirst($_POST["prenom"])));
    $mail = trim(strtolower($_POST["mail"]));
    // Gestion du mdp avec son encodage
    $options = ['cost' => 12];
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT, $options);
    if($_POST["role_admin"]=== true){
        $role = 1;
    }
    else{
        $role = 2;
    }
    // 2- préparation de l'écriture SQL.
    $sql = 'INSERT INTO table_user(nom, prenom, mail, password, role)
            VALUE("'. $nom .'", "' . $prenom .'", "' . $mail .'", "' . $password .'", "' . $role . '")';
 // OU  sans concaténation : 
 // $sql = "INSERT INTO user (first_name,last_name,email,password,role)
 //VALUE ('$first_name', '$last_name', '$email', '$password', '$role')";

 // 3- Éxécution de la requête avec les paramètres de connexion.
 mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
 // 4- Message de confirmation en fonction du rôle (administrateur ou utilisateur).
 if(isset($_POST["role_admin"])){
 $_SESSION["message"] = "Administrateur $nom $prenom est correctement ajouté à la BDD.";
 echo $_SESSION["message"];}else{
    $_SESSION["message"] = "Utilisateur $nom $prenom est correctement ajouté à la BDD.";
    echo $_SESSION["message"];
 }
 // 5- Redirection vers notre page d'accueil (index.php).
 header("Location: ../inc/index.php");
 exit;
}
?>
</main>
<?php
include("../inc/footerFront.php");
?>
