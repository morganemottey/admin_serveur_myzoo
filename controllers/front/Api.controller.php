<?php

require_once "models/front/Api.manager.php";
require_once "models/Model.php";

class APIController {
    private $apiManager;

    public function __construct() {
        $this ->apiManager = new APIManager();
    }
    public function getAnimaux($idFamille, $idContinent) {
        $animaux = $this -> apiManager -> getDBAnimaux($idFamille, $idContinent);
        $tabResultat = $this->formatDataLigneAnimal($animaux);
        // echo "<pre>";
        // print_r($tabResultat);
        // echo "</pre>";
        Model::sendJSON($tabResultat);
    }
    public function getAnimal($idAnimal) {
        $ligneanimal = $this -> apiManager -> getDBAnimal($idAnimal);
        $tabResultat = $this->formatDataLigneAnimal($ligneanimal);
        // echo "<pre>";
        // print_r($tabResultat);
        // echo "</pre>";
        Model::sendJSON($tabResultat);
    }
    private function formatDataLigneAnimal($lignes) {
        $tab = [];

        foreach($lignes as $ligne) {
            if(!array_key_exists($ligne['animal_id'],$tab)) {
                $tab[$ligne['animal_id']] = [
                    "id" => $ligne['animal_id'],
                    "nom" => $ligne['animal_nom'],
                    "description" => $ligne['animal_description'],
                    "image" => URL."public/images/".$ligne['animal_images'], //ajout de l'url exact pour l'accès correct en front
                    "famille" => [
                        "idFamille" => $ligne['famille_id'],
                        "libelleFamille" => $ligne['famille_libelle'],
                        "descriptionFamille" => $ligne['famille_description'],
                    ]
                ];
            }
            $tab[$ligne['animal_id']]['continents'][]= [
                "idContinent" => $ligne['continent_id'],
                "libelleContinent" => $ligne['continent_libelle']
            ];
        }
        return $tab;
        // echo "<pre>";
        // print_r($tab);
        // echo "</pre>";
    }
    public function getContinents() {
        $continents = $this -> apiManager -> getDBContinents();
        Model::sendJSON($continents);
    }
    public function getFamilies() {
        $familles = $this -> apiManager -> getDBFamilles();
        Model::sendJSON($familles);
    }
    public static function sendMessages() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
        
        $obj= json_decode(file_get_contents('php://input'));

        $messageRetour = [
            "from" => $obj ->email,
            "to"=> "morgane.mottey@gmail.com"
        ];
        echo json_encode($messageRetour);
    }
}