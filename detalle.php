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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Quicksand:wght@300..700&family=TASA+Explorer:wght@400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/detalle.css">
</head>
<body>
<!--Colocar Header-->
<?php
$nombrePokemon=$_GET["buscado"];
$conexionBD = mysqli_connect("localhost",
    "root",
        "",
    "pokedexPropia");

$detalleSQL="SELECT * FROM pokemon where nombre='".$nombrePokemon."';";
$resultadoDetalle=mysqli_query($conexionBD,$detalleSQL);

$listaDeEncontrados=mysqli_num_rows($resultadoDetalle);

if($listaDeEncontrados>0){
    $pokemonBuscado = mysqli_fetch_all($resultadoDetalle, MYSQLI_ASSOC);
    $pokemon = $pokemonBuscado[0];
    echo "<div class='detalle-container'>";
    echo "<img src='" . $pokemon["IMG"] . "'>";
    echo "<div class='pokemon-info'>";
    foreach ($pokemon as $key => $value) {
        if ($key != "IMG") {
            echo "<h4>" . $key . " " . $value . "</h4>";
        }
    }
    echo "</div>";
    echo "</div>";
    echo "<a class='volver' href='index.php'>Volver a la Pokedex</a>";
//--------------
}else{
    header("Location:index.php?encontrado=false");
}
$conexionBD->close();
?>
</body>
</html>
