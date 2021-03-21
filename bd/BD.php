<?php
$pdo=null;
$host="localhost";
$user="root";
$password="";
$bd="crudPhp";

function conectar(){
    try
    {
        $GLOBALS['pdo'] = new PDO("mysql:host=".$GLOBALS['host']."; dbname=".$GLOBALS['bd']."",$GLOBALS['user'],$GLOBALS['password']);
        $GLOBALS['pdo']->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } 
    catch(PDOException $e)
    {
        print "Error: no se pudo conectar a la base de datos<br/>";
        print "\nError!: ".$e."<br/>";
        die();
    }
}

function desconectar(){
    $GLOBALS['pdo'] = null;
}

function metodoGet($query){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query);
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        $sentencia->execute();
        desconectar();
        return $sentencia;
    } catch (\Throwable $th) {
       die("Error: " .$th);
    }
}

function metodoPost($query, $idAutoIncrement){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $idAutoIncrement = metodoGet($idAutoIncrement)->fetch(PDO::FETCH_ASSOC);
        $resultado = array_merge($idAutoIncrement, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;
    } catch (\Throwable $th) {
       die("Error: " .$th);
    }
}

function metodoPut($query){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $resultado = array_merge($_GET, $_POST);
        $sentencia->closeCursor();
        desconectar();
        return $resultado;
    } catch (\Throwable $th) {
       die("Error: " .$th);
    }
}

function metodoDelete($query){
    try {
        conectar();
        $sentencia= $GLOBALS['pdo']->prepare($query);
        $sentencia->execute();
        $sentencia->closeCursor();
        desconectar();
        return $_GET['id'];
    } catch (\Throwable $th) {
       die("Error: " .$th);
    }
}