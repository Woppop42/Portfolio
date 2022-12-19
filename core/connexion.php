<?php
//La configuration de la connexion à la base de données.
//Création d'une variable $online avec le type bool.

$online = false;
if(!$online){
    $host = "localhost";
    $user = "root";
    $password = "root"; // Spécificité MAC sinon valeur = "".
    $bdd = "portfolio";
} else{
    //A remplir avec les données que fournira l'hébergeur.
    $host = "";
    $user = "";
    $password = "";
    $bdd = "";
}
//Mise en place de la connexion à la bdd.
$connexion = mysqli_connect($host, $user, $password, $bdd);
//Passage des retours de requêtes au format d'encodage UTF-8.
mysqli_query($connexion, "SET NAMES 'utf8' "); 
?>