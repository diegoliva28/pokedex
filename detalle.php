<?php
//Validar por session
session_start();
if(!isset($_SESSION["usuario"])){
    header("Location:login.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Detalle</title>
</head>
<body>
<!--Colocar Header-->
<?php
$nombrePokemon=$_GET["buscado"];
$conexionBD = mysqli_connect("localhost",
    "root",
        "",
    "pokedex");

$detalleSQL="SELECT * FROM pokemon where nombre='".$nombrePokemon."';";
$resultadoDetalle=mysqli_query($conexionBD,$detalleSQL);

$listaDeEncontrados=mysqli_num_rows($resultadoDetalle);

if($listaDeEncontrados>0){
    $pokemonBuscado = mysqli_fetch_all($resultadoDetalle, MYSQLI_ASSOC);
    $pokemon = $pokemonBuscado[0];
    echo "<div>";
    echo "<img src='" . $pokemon["IMG"] . "'>";
    foreach ($pokemon as $key => $value) {
        if ($key != "IMG") {
            echo "<h4>" . $key . " " . $value . "</h4>";
        }
    }
    echo "</div>";
//--------------
}else{
    header("Location:index.php?encontrado=false");
}
$conexionBD->close();
?>
</body>
</html>
