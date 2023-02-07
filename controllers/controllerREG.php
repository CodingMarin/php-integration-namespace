<?php
namespace controllers;
require_once('../models/conexion.php');

use models\conexion;
use PDO;

class controllerREG extends conexion
{
    private $struserid;
    private $strname;
    private $strsurname;
    private $strage;
    private $stremail;
    private $strRegDate;
    private $db; 
    public function __construct()
    {
        $this->db = parent::getPDOConnect();
    }
    public function register($userid,$name,$surname,$age,$email,$password)
    {
        $this->struserid   = $userid;
        $this->strname     = $name;
        $this->strsurname  = $surname;
        $this->strage      = $age;
        $this->stremail    = $email;
        $this->strRegDate  = date('Y-m-d H:i:s');
        $this->strPassword = password_hash($password,PASSWORD_ARGON2ID);

        $stmt = $this->db->prepare('INSERT INTO account (UserID,Name,Surname,Age,Email,UGradeID,RegDate)
                                    VALUES (:userid,:name,:surname,:age,:email,0,:regdate)');
        $stmt->bindValue(':userid',$this->struserid,PDO::PARAM_STR);
        $stmt->bindValue(':name',$this->strname,PDO::PARAM_STR);
        $stmt->bindValue(':surname',$this->strsurname,PDO::PARAM_STR);
        $stmt->bindValue(':age',$this->strage,PDO::PARAM_INT);
        $stmt->bindValue(':email',$this->stremail,PDO::PARAM_STR);
        $stmt->bindValue(':regdate',$this->strRegDate);
        $stmt->execute();
        $aid = $this->db->lastInsertId();
        
        $strAid = $aid;
        $stmt = $this->db->prepare('INSERT INTO login (AID,UserID,Password) VALUES (:AID,:UserID,:Password)');
        $stmt->bindValue(':AID',$strAid,PDO::PARAM_INT);
        $stmt->bindValue(':UserID',$this->struserid,PDO::PARAM_STR);
        $stmt->bindValue(':Password',$this->strPassword,PDO::PARAM_STR);
        $stmt->execute();

        header('location: ../src/vista');
    }
    public static function issetRegistro($column,$value)
    {
        $host = new conexion();
        $db = $host->getPDOConnect();
        $stmt = $db->prepare('SELECT *FROM account WHERE '.$value.' = :column');   
        $stmt->bindParam(':column',$column,PDO::PARAM_STR);
        $stmt->execute();  
        switch ($stmt->fetchColumn())
        {
            case 0:
                return false;
                break;
            default:
                return true;

                break;
        }
    }
}
?>