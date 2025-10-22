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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Quicksand:wght@300..700&family=TASA+Explorer:wght@400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/darAlta.css">
    <title>Registrar Pokemon</title>
</head>
<body>
    
<header class="encabezado">
    <img src="img/pokebola.png" alt="logo" style="width: 10vh">
    <h1>Pokedex</h1>
    <?php
    if (isset($_SESSION["usuario"])) {
        echo "<h4>" . $_SESSION["usuario"] . "</h4>";
    } else {
        echo '<form action="login.php" method="POST" enctype="multipart/form-data">
                    <input type="text" name="username" placeholder="Usuario">
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit">Ingresar</button>
              </form>';
    }
    ?>
</header>
    <div class="contenedor">
        <h1 class="titulo">Dar de alta un pokemon:</h1>
        <form action="" method="POST" enctype="multipart/form-data"
            style="display: flex; flex-direction: column">
            <label for="" >Numero</label>
            <input type="number" name="numero">
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
            <input type="submit" value="Agregar" class="boton">
        </form>
    </div>
</body>


<?php
$valoresFormulario = ["numero", "nombre", "descripcion", "tipo"];

//valido que esten declaradas
//valido que no esten vacias
$valor = true;
$i = 0;
while ($valor && $i < sizeof($valoresFormulario)) {
    if (!isset($_POST[$valoresFormulario[$i]])) {
        $valor = false;
    } else if (strlen($_POST[$valoresFormulario[$i]]) == 0) {
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

//guardar img
$pathImg = "";
if ($valorImg) {
    move_uploaded_file($_FILES["img"]["tmp_name"], "img/" . $_POST["nombre"] . ".png");
    $pathImg = "img/" . $_POST["nombre"] . ".png";
}

//Conexion a la base de datos
//Validacion de que se haya enviado algo
if ($valorImg && $valor) {
    $conexionBD = mysqli_connect("localhost",
            "root",
            "",
            "pokedexPropia");

    $nuevoRegistroQuery = "insert into pokemon (NRO,IMG,NOMBRE,TIPO,DESCRIPCION)
    values (
            " . $_POST["numero"] . ",
            '" . $pathImg . "',
            '" . $_POST["nombre"] . "',
            '" . $_POST["tipo"] . "',
            '" . $_POST["descripcion"] . "');";

    $nombreRepetidoQuery = "select * from pokemon where nombre='" . $_POST["nombre"] . "';";
    $idRepetidoQuery = "select * from pokemon where nro='" . $_POST["numero"] . "';";


    $resultadoNombre = mysqli_query($conexionBD, $nombreRepetidoQuery);
    $resultadoId = mysqli_query($conexionBD, $idRepetidoQuery);

    $repetidoNombre = mysqli_num_rows($resultadoNombre);
    $repetidoId = mysqli_num_rows($resultadoId);

    if ($repetidoNombre == 0 && $repetidoId == 0) {
        $resultadoInsert = mysqli_query($conexionBD, $nuevoRegistroQuery);

        $conexionBD->close();
        header("Location:index.php");
    } else {
        echo "<H3>Tenes campos repetidos</H3>";
    }
    $conexionBD->close();
} else {
    echo "<H3>Por favor complete todos los campos</H3>";
}
?>
</html>
