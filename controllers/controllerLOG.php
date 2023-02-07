<?php
namespace controllers;
require_once '../models/conexion.php';
use models\conexion;
use PDO;

class controllerLOG extends conexion
{
    private $username;
    private $nombre;

    public function login($usermail,$password)
    {
        $this->username = $usermail;
        if (empty($usermail) || empty($password)) {
            echo '<script>alert("completa todos los campos")</script>';
        }else{
            $stmt = $this->getPDOConnect()->prepare('SELECT username, password FROM login WHERE username = :u AND password = :p');
            if (false === $stmt) {
                echo 'Error en sentencia sql';
            } else {
                $stmt->bindParam(':u', $usermail, PDO::PARAM_STR);
                $stmt->bindParam(':p', $password, PDO::PARAM_STR);
                $stmt->execute();
                $resultate = $stmt->fetchAll(PDO::FETCH_OBJ);
                if (!$resultate) {
                    echo 'Datos invalidos';
                } else {
                    echo 'acceso permitido';
                }
            }
        }
    }
    public function setUser($user){
        $query = $this->getPDOConnect()->prepare('SELECT * FROM account WHERE UserID = :user');
        $query->execute(['user' => $user]);

        foreach ($query as $currentUser) {
            $this->nombre = $currentUser['nombres'];
        }
    }

    public function getNombre(){
        return $this->nombre;
    }
}

$new = new controllerLOG();

print_r($new->setUser("marinalexander691@gmail.com"));

print_r($new->getNombre());
?>