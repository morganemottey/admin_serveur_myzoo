<?php
define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/front/Api.controller.php";
require_once "controllers/back/admin.controller.php";
$apiController = new APIController();
$adminController = new Admincontroller();

try {
    if(empty($_GET['page'])) {
        throw new Exception("La page n'existe pas !");
    } else {
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL)); // permet d'exploser une url de manière sécurisé
        if(empty($url[0]) || (empty($url[1]))) throw new Exception("La page n'existe pas !"); // empty permet de voir si c'est vide ou n'existe pas, si notre url est vide on affichera une erreur
        // on va devoir testé tout d'abord notre url[0]
        switch($url[0]) {
            case 'front' : // nous allons ensuite testé l'url1
                switch($url[1]){
                    case 'animaux':
                    if(!isset($url[2]) || !isset($url[3])) { // localhost:8080/front/animaux/?/?
                        $apiController -> getAnimaux(-1, -1);
                    } else {
                        $apiController -> getAnimaux((int)$url[2],(int)$url[3]); // int permet de transformer nos id en entier
                    }
                    break; // apres avoir réinitialisé nos url , nous allons envoyé ces informations dans api.manager.pho au niveau de la bdd getBddAnimaux()
                    case 'animal': // on va tester maintena,t les url afin de pouvoir filtrer
                        if(empty($url[2])) throw new Exception("L'identifiant de l'animal n\'existe pas");
                        $apiController -> getAnimal($url[2]);
                    break;
                    case 'continents': $apiController -> getContinents();
                    break;
                    case 'familles' : $apiController -> getFamilies();
                    break;
                    case 'sendMessages' : $apiController -> sendMessages();
                    break;
                    default : throw new Exception("La page n'existe pas !");
                }
            break;
            case 'back' : 
                switch($url[1]){
                case 'login': $adminController -> getPageLogin();
                break;
                case 'connexion': $adminController -> connexion();
                break;
                default : throw new Exception("La page n'existe pas !");
            }
            break;
            default : throw new Exception("La page n'existe pas !");
        }
    } 
} catch(Exception $e) {
    $msg = $e->getMessage();
    echo $msg;
}