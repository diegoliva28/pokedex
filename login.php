<?php
session_start();

//Valores de formulario
$nombreUsuario = $_POST["username"];
$contraUsuario = $_POST["password"];

//Conexion a la base de datos
$conexionBD = mysqli_connect("localhost",
    "root",
    "",
    "pokedex");

$usuarioQuery = "SELECT * FROM usuarios 
         where nombre='" . $nombreUsuario . "' 
         and contra='" . $contraUsuario . "';";

$resultadoLogin = mysqli_query($conexionBD, $usuarioQuery);
$cantidadDeUsuariosEncontrados = mysqli_num_rows($resultadoLogin);

if ($cantidadDeUsuariosEncontrados == 1) {
    $_SESSION["usuario"]=$nombreUsuario;

    $conexionBD->close();
    header("Location:index.php");
}else{
    $conexionBD->close();
    header("Location:index.php");
}
