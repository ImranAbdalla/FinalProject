<?php

    $database= new mysqli("localhost","root","","edoc2");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>