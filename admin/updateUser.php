<?php

include("../inc/headBack.php");
?>
<title>Modification de l'utilisateur</title>
<?php
include("../inc/headerBack.php");

?>
<?php
//TODO Si l'utilisateur n'est pas connecté ou n'est pas administrateur, le rediriger et lui afficher un message l'invitant à se connecter. Utiliser $_SESSION.
if($_SESSION["role"]!=1 || $_SESSION["role"]===NULL){
$_SESSION["message"] = 'Veuillez vous connecter avec un profil valide SVP.';
header("Location: ./index.php");
}
// Choix de l'id de l'utilisateur.
$id = 6;
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

var_dump($_GET);
if(isset($_GET["execute"])){
echo 'ID Utilisateur ' .  htmlspecialchar($_GET["id_user"]) . '<br>';
}
?>

<main>
    <div class="container">
        <div class="row-justify-content text-center">
            <h3>Détails de l'utilisateur</h3>
            <form action="../core/userController.php" method="post">
                <input type="hidden" name="execute" value="log-out">
            <button class="btn btn-warning"  type="submit">Se déconnecter</button>
</form>
    </div>
</div>
</main>
