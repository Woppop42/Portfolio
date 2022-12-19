Nous allons créer un site Portfolio
- Partie front
- Partie back-office (admin) qui permettra au webmaster de configurer le site ou de récupérer des informations. 
- Au niveau de la BDD :
    - Une table user avec plusieurs champs : nom / prenom / mail / date de naissance / mdp / rôle.
    - Ajout d'une table message où l'on récupère nom / prénom / mail / société / téléphone / message.
    
Les différences entre include() et require () :
require() rend les éléments entre parentheses indispensables : message d'erreur automatique (Fatal Error) si erreur avec require(). Pas le cas avec include() qui est plus permissif et permettra de continuer à lire le code.
include() : Fichier facultatif.
require(): Fichier obligatoire.

Un controller sert d'aiguillage. Contient uniquement du code serveur dont le but est de rediriger vers d'autres pages. Ne contient pas de code "visuel". Contient seulement de la logique. 