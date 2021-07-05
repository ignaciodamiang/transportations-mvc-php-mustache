<?php

session_start();

require "conexion.php";


$id = isset($_POST["numero"]) ? $_POST["numero"] : "";
$nombre = isset($_POST["nombrePokemon"]) ? $_POST["nombrePokemon"] : "";
$tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";


$nuevoNombre = ucfirst($nombre);
$rutaParaGuardar = "recursos/imgPokemon/";
$fijarArchivo = $rutaParaGuardar . $nuevoNombre;
$tipoDeArchivo = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
$nombreImagen = $nuevoNombre . "." . $tipoDeArchivo;

$sql = "SELECT * FROM Pokemon WHERE id = '$id'";

$insert = $conexion->query($sql);

if (move_uploaded_file($_FILES["file"]["tmp_name"], $fijarArchivo . "." . $tipoDeArchivo)) {

    if ($insert) {
        $sql2 = "INSERT INTO Pokemon (id,nombre,descripcion,tipo,imagen) 
		            VALUES('$id ','$nuevoNombre', '$descripcion', '$tipo','$nombreImagen') ";

        $conexion->query($sql2);


        header("location:pokedex.php");
        exit();
    }

}
echo "mal";

?>