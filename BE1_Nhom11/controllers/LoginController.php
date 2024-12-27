<?php
// app/controllers/LoginController.php
namespace App\Controllers;

class LoginController {

    public function handleRequest() {
        // Show the login view
        $this->showLogin();
    }

    public function showLogin() {
        // Include view to show login form
        include_once '../views/login.php';
    }
}
