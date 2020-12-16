<?php 

require_once "controllers/back/admin.controller.php";

class AdminController {
    public function __construct() {
    }
    public function getPageLogin() {
       require_once"views/login.views.php";
    }
    public function connexion() {
        if(!empty($_POST['login']) && !empty($_POST['password'])) {
            $login = Securite :: secureHTML($_POST['login']);
            $password = Securite :: secureHTML($_POST['password']); 
        }
     }
}