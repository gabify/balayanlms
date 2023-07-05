<?php

    require 'config.php';

    function connect($host, $db, $user, $pass){
        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try{
            
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            
            return new PDO($dsn,$user,$pass, $options);

        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    return connect($host, $db, $user, $pass);
?>