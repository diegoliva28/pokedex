<?php
session_start();
if (isset($_SESSION['usuario'])) {
    $conexionBD = mysqli_connect("localhost",
        "root",
        "",
        "pokedexPropio");

    $eliminarPokemonQuery = "Delete from pokemon where nombre='" . $_GET["pokemon"] . "'";
    $resultado = mysqli_query($conexionBD, $eliminarPokemonQuery);
    $conexionBD->close();

    header("Location:index.php");
}else{
    header("Location:index.php");
}

