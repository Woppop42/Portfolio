<?php
include("../inc/headBack.php");
if (!isset($_SESSION["role"], $_SESSION["isLogged"], $_SESSION["prenom"]) || !$_SESSION["isLogged"] || $_SESSION["role"] != 1) {
    // L'utilisateur n'a pas le droit : redirigeons-le!
    $_SESSION["message"] = "Vous n'avez pas le droit d'accès à l'administration";
    header("Location: ../admin/index.php");
    exit;
}
?>
<title>Suppression utilisateur</title>
<?php
include("../headerBack.php");
