<?php
SESSION_START();
if (!isset($_SESSION["usuario"])) {
    header("location:index.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Pokemon</title>
    <link rel="stylesheet" href="styles/modificar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Quicksand:wght@300..700&family=TASA+Explorer:wght@400..800&display=swap" rel="stylesheet">
</head>
<body>
<?php
$nombrePokemon = $_GET["pokemon"];
$conexionBD = mysqli_connect("localhost",
    "root",
    "",
    "pokedex");

$detalleSQL = "SELECT * FROM pokemon where nombre='" . $nombrePokemon . "';";
$resultadoDetalle = mysqli_query($conexionBD, $detalleSQL);

$listaDeEncontrados = mysqli_num_rows($resultadoDetalle);

if ($listaDeEncontrados > 0){
$pokemonBuscado = mysqli_fetch_all($resultadoDetalle, MYSQLI_ASSOC);
$pokemon = $pokemonBuscado[0];
echo "<div class='modificar-container'>";
echo "<img src='" . $pokemon["IMG"] . "'>";
echo "<div class='info-form'>";
echo "<div class='pokemon-info'>";
foreach ($pokemon as $key => $value) {
    if ($key != "IMG") {
        echo "<h4>" . $key . " " . $value . "</h4>";
    }
}
echo "</div>";
echo "</div>";
echo "</div>";
}
$conexionBD->close();
?>
<form action="" method="POST" enctype="multipart/form-data"
      style="display: flex; flex-direction: column">
    <label for="">Numero</label>
    <input type="number" name="nro">
    <label for="">Nombre</label>
    <input type="text" name="nombre">
    <label for="">Descripcion</label>
    <input type="text" name="descripcion">
    <label for="">Tipo</label>
    <select name="tipo" id="">
        <option value="fuego">Fuego</option>
        <option value="agua">Agua</option>
        <option value="planta">Planta</option>
    </select>
    <label for="">Imagen del Pokemon</label>
    <input type="file" name="img">
    <input type="submit" value="modificar">
</form>
</body>
<?php
$valoresFormulario = ["nro", "nombre", "descripcion", "tipo"];

//valido que esten declaradas
//valido que no esten vacias
$valor = true;
$i = 0;
while ($valor && $i < sizeof($valoresFormulario)) {
    if (!isset($_POST[$valoresFormulario[$i]])) {
        $valor = false;
    }
    $i++;
}
//Valido imagen
$valorImg = true;
if (!isset($_FILES["img"])) {
    $valorImg = false;
} elseif ($_FILES["img"]["error"] != 0) {
    $valorImg = false;
}

$camposAModificar = [];
if($valor){
    foreach ($_POST as $key => $valor) {
        if (strlen($valor)>0) {
            $camposAModificar[$key] = $valor;
        }
        echo $key . ": " . $valor . "<br>";
    }
}

//guardar img
$pathImg = "";
if ($valorImg && isset($_POST["nombre"])) {
    move_uploaded_file($_FILES["img"]["tmp_name"], "img/" . $_POST["nombre"] . ".png");
    $pathImg = "img/" . $_POST["nombre"] . ".png";
}

//Conexion a la base de datos
//Validacion de que se haya enviado algo
    $conexionBD = mysqli_connect("localhost",
        "root",
        "",
        "pokedex");
if ($valor) {
    foreach ($camposAModificar as $key => $value) {
        $modificacionQuery = "UPDATE pokemon SET " . $key . "='" . $value . "' where nombre='" . $_GET["pokemon"] . "';";
        mysqli_query($conexionBD, $modificacionQuery);
    }
}
if ($valorImg && isset($_POST["nombre"])) {
    $Query = "UPDATE pokemon SET IMG='" .$pathImg . "' where nombre='" . $_POST["nombre"]."';";
    echo $pathImg."<br>";
    echo $modificacionQuery;
    var_dump(mysqli_query($conexionBD, $Query));

}

if ($valorImg || $valor) {
header("location:index.php");
}
?>
</html>

