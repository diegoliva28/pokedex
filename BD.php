<?php

//echo "arrived" ;


//Intentar hacer la conexion con un archivo INI
$conexionBD = mysqli_connect("localhost",
    "root",
    "",
    "pokedexPropio");
//var_dump($conexionBD);
//echo "<br>";
//print_r($conexionBD);

$query = "SELECT * FROM pokemon";
$resultado = mysqli_query($conexionBD, $query);

//print_r($resultado);

$cantidadDeRegistros = mysqli_num_rows($resultado);

echo "cantidad de filas " . $cantidadDeRegistros . "<br>";

$tabla = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

echo "<br>";
var_dump($tabla);
echo "<br>";
for ($i = 0; $i < $cantidadDeRegistros; $i++) {
    echo $tabla[$i]["NOMBRE"] . "<br>";
}
echo "<br>";

foreach ($tabla as $fila) {
    echo $fila["NOMBRE"] . "<br>";
}

//$queryDelete="DELETE from pokemon WHERE nro=3";
//$resultado = mysqli_query($conexionBD, $queryDelete);
//var_dump($resultado);

$queryUpdate = "UPDATE pokemon set IMG='img/charmander.png' WHERE NOMBRE='charmander'";
$resultado = mysqli_query($conexionBD, $queryUpdate);
var_dump($resultado);

echo "<br>";

//Obtener cabeceras de una tabla
$cabeceras="SHOW columns from pokemon";
//Con COLUMNS me trae el nombre de las caberas de una tabla
$resultado = mysqli_query($conexionBD, $cabeceras);

var_dump($resultado);
print_r($resultado);

$cantidad=mysqli_num_rows($resultado);
echo "cantidad de filas " . $cantidad . "<br>";

echo "<br>";

$cabeceras=mysqli_fetch_all($resultado, MYSQLI_ASSOC);
var_dump($cabeceras);

$nombreDeCabeceras=[];

foreach ($cabeceras as $fila) {
    echo $fila["Field"] . "<br>";
    $nombreDeCabeceras[] = $fila["Field"];
//    array_push($nombreDeCabeceras, $fila["Field"]);
}
 var_dump($nombreDeCabeceras);