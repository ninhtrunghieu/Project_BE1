<?php
// app/models/User.php
namespace App\Models;

class User {

    public $username;
    public $password;

    public function __construct($username, $password) {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate() {
        // Logic to authenticate user (e.g., check credentials in a database)
    }
}
