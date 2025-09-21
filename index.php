<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokedex</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&family=Quicksand:wght@300..700&family=TASA+Explorer:wght@400..800&display=swap" rel="stylesheet">
    <style>
        img {
            width: 30%;
        }
    </style>
</head>
<body>
<header style="display: flex; justify-content: space-around; align-items: center">
    <img src="img/pokebola.png" alt="logo" style="width: 10vh">
    <h1>Pokedex</h1>
    <?php
    session_start();
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

<!--Esto me lleva al detalle del pokemon-->
<?php
if (isset($_SESSION["usuario"]) && isset($_GET["encontrado"])) {
        echo "<h3>Pokemon no encontrado</h3>";
}
?>
<form action="detalle.php" method="GET" enctype="multipart/form-data">
    <input type="text" name="buscado" placeholder="Ingrese el nombre, tipo o numero del pokemon">
    <button type="submit">Buscar</button>
</form>

<table>
    <?php
    //Coneccion a la base de datos
    $conexionBD = mysqli_connect("localhost",
            "root",
            "",
            "pokedex");

    //Consulta de cabeceras de la tabla
    $cabeceraQuery = "Show columns FROM pokemon";
    $consultaCabecera = mysqli_query($conexionBD, $cabeceraQuery);
    $cantidadDeCabeceras = mysqli_num_rows($consultaCabecera);
    $tablaCabeceras = mysqli_fetch_all($consultaCabecera, MYSQLI_ASSOC);

    $cabecerasName = [];
    foreach ($tablaCabeceras as $cabecera) {
        $cabecerasName[] = $cabecera["Field"];
    }

    //Impresion de cabeceras
    for ($i = 0; $i < $cantidadDeCabeceras; $i++) {
        echo "<th>" . $cabecerasName[$i] . "</th>";
    }

    $acciones = ["Modificar", "Eliminar"];
    if (isset($_SESSION["usuario"])) {
        echo "<th>Acciones</th>";
    }

    //Consulta de pokemones totales
    $pokemonQuery = "SELECT * FROM pokemon";
    $resultadoPokemon = mysqli_query($conexionBD, $pokemonQuery);
    $cantidadPokemon = mysqli_num_rows($resultadoPokemon);
    $tablaPokemon = mysqli_fetch_all($resultadoPokemon, MYSQLI_ASSOC);

    //Impresion de cuerpo de la tabla con pokemones totales
    for ($i = 0; $i < $cantidadPokemon; $i++) {
        echo "<tr>";
        //Impresion de los campos de la tabla
        foreach ($tablaPokemon[$i] as $campo => $datoPokemon) {
            if ($campo == "IMG") {
                $imgPokemon = $datoPokemon;
                echo "<td><img src='" . $imgPokemon . "'></td>";
            } else {
                echo "<td>" . $datoPokemon . "</td>";
            }
        }
        //Botones de accion
        if (isset($_SESSION["usuario"])) {
            echo "<td>";
            for ($x = 0; $x < sizeof($acciones); $x++) {
                $nombreDelPokemon = $tablaPokemon[$i]["NOMBRE"];
                $enlace = strtolower($acciones[$x]) . ".php?pokemon=" . $nombreDelPokemon;
                echo "<a href=" . $enlace . ">" . $acciones[$x] . "</a>";
            }
            echo "</td>";
        }
        echo "</tr>";
    }
    $conexionBD->close();
    ?>
</table>

<a href="darAlta.php">Nuevo pokemon</a>
</body>
</html>
