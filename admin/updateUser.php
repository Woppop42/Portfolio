<?php

include("../inc/headBack.php");
?>
<title>Modification de l'utilisateur</title>
<?php
include("../inc/headerBack.php");

?>


<main>
    <div class="container">
        <div class="row-justify-content text-center">
            <h3>Détails de l'utilisateur</h3>
            <?php
//TODO Si l'utilisateur n'est pas connecté ou n'est pas administrateur, le rediriger et lui afficher un message l'invitant à se connecter. Utiliser $_SESSION.
if($_SESSION["role"]!=1 || $_SESSION["role"]===NULL){
$_SESSION["message"] = 'Veuillez vous connecter avec un profil valide SVP.';
header("Location: ./index.php");
}
// Choix de l'id de l'utilisateur.
$id = $_GET["id_user"];
require("../core/connexion.php");
$sql = "SELECT `id_user`, `nom`, `prenom`, `mail`, `role`
        FROM table_user
        WHERE id_user = $id ";  // en SQL un = simple suffit.

$query = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
$user = mysqli_fetch_ASSOC($query);
echo '<pre>';
var_dump($user);
echo '</pre>';
//TODO Afficher les infos de l'utilisateur sur la page.
// Afficher un utilisateur en fonction de son id quand on clique dessus depuis la liste des utilisateurs.
echo 'ID Utilisateur = ' . $user["id_user"] . '<br>';
echo 'NOM = '. $user["nom"] . '<br>';
echo 'PRENOM = '. $user["prenom"] . '<br>';
echo 'MAIL = ' . $user["mail"] . '<br>';
echo 'ROLE = ' . $user["role"] . '<br>';

?>
            <form action="../core/userController.php" method="post">
                <input type="hidden" name="execute" value="log-out">
            <button class="btn btn-warning"  type="submit">Se déconnecter</button>
            </form>
    </div>
    <div class="row-justify-content text-center">
    <h3>Modifier l'utilisateur</h3>
    <div class="row mt-5">
        <?php if(isset($_SESSION["message"])){
            echo '<div class="alert alert-succes" role="alert">' . $_SESSION["message"] . '</div>';
            unset($_SESSION["message"]);
        }
        ?>
    </div>
        <div class="form-control">
        <form method="POST" action="../core/userController.php">
        <input type="hidden" class="form-control mt-3" name="execute" value="update">
        <input type="hidden" class="form-control !t-3" name="id_user" value="<?= $user["id_user"]; ?>">
            <label for="nom">Nom</label>
            <input type="text" name="nom" class="form-control" id="nom" value="<?= $user["nom"];?>" />
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" class="form-control" id="prenom" value="<?= $user["prenom"];?>"/>
            <label for="mail">Mail</label>
            <input type="email" name="mail" id="mail" class="form-control" value="<?= $user["mail"];?>" />
            <label for="password">Mot de passe</label>
            <input type="password"  class="form-control" name="password" id="password" />
            <label for="role">Rôle</label>
            <select class="form-control" name="role" id="role">
                <option value="2" <?php if($user["role"] == 2){
                    echo "selected";} ?>>Utilisateur</option>
                <option value="1" <?php if($user["role"] == 1){
                    echo "selected";} ?>>Administrateur</option>
            </select>
            <br>
            <button type="submit" class="btn btn-warning">Modifier</button>
        </form>
        </div>
    </div>
</div>
</main>
