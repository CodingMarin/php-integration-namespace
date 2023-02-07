<?php
namespace functions;

function Messenger($value,$message){

    $array_log = array();
    array_push($array_log,$message);
    array_push($array_log,$message);
    for ($i=0; $i <count($array_log); $i++) { 
        return $array_log[$value];

    }
};

echo Messenger(2,'Soy el array numero 1');
?>