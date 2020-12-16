<?php

abstract class Model {
    private static $pdo;

    private static function setBdd() { //function permettant de faire la récupération de la bdd
        self::$pdo = new PDO("mysql:host=localhost;dbname=dbanimaux;charset=utf8","root","");//permet d'appeler notre variable static $pdo
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    protected function getBdd() { //permet de récupérer la fonction plus haut pour transmettre la connexion
        if(self::$pdo === null) {
            self::setBdd();
        }
        return self::$pdo;
    }
    public static function sendJSON($info) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        echo json_encode($info);
    }
}