<?php

include("../inc/headBack.php");
?>
<title>Console d'administration</title>
<?php
include("../inc/headerBack.php");
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
?>
<?php
//TODO Si l'utilisateur n'est pas connecté ou n'est pas administrateur, le rediriger et lui afficher un message l'invitant à se connecter. Utiliser $_SESSION.
if($_SESSION["role"]!=1 || $_SESSION["role"]===NULL){
$_SESSION["message"] = 'Veuillez vous connecter avec un profil valide SVP.';
header("Location: ./index.php");

}
?>
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
