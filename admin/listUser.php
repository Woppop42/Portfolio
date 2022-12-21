<?php

include("../inc/headBack.php");
?>
<title>Liste des utilisateurs</title>
<?php
include("../inc/headerBack.php");
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
?>
<h1 class="text-center">Liste des utilisateurs</h1>
<?php
//TODO Si l'utilisateur n'est pas connecté ou n'est pas administrateur, le rediriger et lui afficher un message l'invitant à se connecter. Utiliser $_SESSION.
if($_SESSION["role"]!=1 || $_SESSION["role"]===NULL){
$_SESSION["message"] = 'Veuillez vous connecter avec un profil valide SVP.';
header("Location: ./index.php");
}
require("../core/connexion.php");
// Requête pour récuperer les informations des champs de la table des utilisateurs.
$sql = "SELECT `id_user`, `nom`, `prenom`, `mail`, `role` 
        FROM `table_user` ";
// Requête passe par le base de données : 
$query = mysqli_query($connexion, $sql) or die(mysqli_error($connexion));
// Renvoi de toutes les informations dans un tableu associatif.
$users = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>
<table class="table table-border">
    <tr>
        <th>ID</th>
        <th>NOM</th>
        <th>PRENOM</th>
        <th>MAIL</th>
        <th>ROLE</th>
        <th>ACTION</th>
    </tr>
    <?php
foreach($users as $user){
    //TODO Pour chaque utilisateur, créer une nouvelle ligne (tr) et afficher ses infos dans des cellules (td).
    //echo '<h4> Utilisateur : '.$user["nom"] . '</h4>';
    //echo '<pre>';
    //var_dump($user);
    //echo '</pre>';
    ?>
    <tr>
        <td><?php echo '<form method="get">
                <input type="hidden" name="execute">'. 
            '<a class="btn btn-warning"  type="submit" href="updateUser.php">'. $user["id_user"] .'</a></form>'; ?></td>
        <td><?php echo $user["nom"]; ?></td>
        <td><?= $user["prenom"]; ?></td>
        <td><?= $user["mail"]; ?></td>
        <td><?php if($user["role"]== 1){
            echo "Administrateur";
        } else{
            echo "Utilisateur";
        }
        ; ?></td>
        <td></td>
</tr>
    <?php
}
?>
</table>

<main>
    <div class="container">
        <div class="row-justify-content text-center">
            <h3>Bienvenue <?=$_SESSION["prenom"] ?></h3>
            <form action="../core/userController.php" method="post">
                <input type="hidden" name="execute" value="log-out">
            <button class="btn btn-warning"  type="submit">Se déconnecter</button>
</form>
    </div>
</div>
</main>