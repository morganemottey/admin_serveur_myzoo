<?php

require_once 'models/Model.php';

class APIManager extends Model{ //permet d'étendre le fichier Model afin de faire la connexion à la base de donnée
    public function getDBAnimaux($idFamille, $idContinent) {
        //apres initialisation des deux id nous allons les tester en passant par des variables et en adaptant notre close where
        $whereClause = '';
        if($idFamille !== -1 || $idContinent !== -1) $whereClause .= "WHERE ";
        if($idFamille !== -1) $whereClause .= "f.famille_id = :idFamille";
        if($idFamille !== -1 && $idContinent !== -1) $whereClause .= " AND ";
        // if($idContinent !== -1) $whereClause .= "c.continent_id = :idContinent"; nous sommes obligés de rajouter un autre filtre pour pouvoir conservé nos boutons sur la partie front
        if($idContinent !== -1) $whereClause .= "a.animal_id IN (
            select animal_id from animal_continent where continent_id = :idContinent
        )";
        $req = "SELECT * 
        from animal a inner join famille f on f.famille_id = a.famille_id
        inner join animal_continent ac on ac.animal_id = a.animal_id
        inner join continent c on c.continent_id = ac.continent_id ".$whereClause; //nous commencons nos requetes de la bdd
        $stmt = $this->getBdd()->prepare($req);// fait la connexion à la bdd et la prépare
        if($idFamille !== -1) $stmt->bindValue(":idFamille",$idFamille, PDO::PARAM_INT);
        if($idContinent !== -1) $stmt->bindValue(":idContinent",$idContinent, PDO::PARAM_INT);
        $stmt->execute(); //execute notre requete de la bdd;
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC); //Fetch_Assoc permet de ne pas avoir deux fois les meme infos de nos lignes
        $stmt->closeCursor(); //permet de fermer la requete
        return $animaux;
    }
    public function getDBAnimal($idAnimal) {
        $req = "SELECT * 
        from animal a inner join famille f on f.famille_id = a.famille_id
        inner join animal_continent ac on ac.animal_id = a.animal_id
        inner join continent c on c.continent_id = ac.continent_id
        WHERE a.animal_id = :idAnimal"; //nous ajoutons un filtre pour filtrer notre bdd en fonction notre id de maniere sécurier avec bindValue() relatif à PDO
        $stmt = $this->getBdd()->prepare($req);// fait la connexion à la bdd et la prépare
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $ligneanimal = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        $stmt->closeCursor();
        return $ligneanimal;
    }
    public function getDBContinents() {
        $req = "SELECT * from continent";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $continents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $continents;
    }
    public function getDBFamilles() {
        $req = "SELECT * from famille";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $familles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $familles;
    }
}